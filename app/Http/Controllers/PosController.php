<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('pos.index', compact('customers', 'products'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('barcode', 'like', "%{$query}%");
            })
            ->take(20)
            ->get();
            
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method' => 'required|in:cash,transfer',
            'paid_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'items' => 'required|json'
        ]);

        $items = json_decode($request->items, true);
        if (empty($items)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $invoiceNo = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $transaction = Transaction::create([
                'invoice_no' => $invoiceNo,
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'subtotal' => 0, // will update later
                'discount' => $request->discount ?? 0,
                'total' => 0, // will update later
                'payment_method' => $request->payment_method,
                'paid_amount' => $request->paid_amount,
                'change_amount' => 0, // will update later
                'status' => 'completed'
            ]);

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);
                
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi. Sisa: {$product->stock}");
                }

                $itemSubtotal = $product->sell_price * $item['qty'];
                $subtotal += $itemSubtotal;

                // Create Transaction Item
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'buy_price' => $product->buy_price,
                    'sell_price' => $product->sell_price,
                    'subtotal' => $itemSubtotal
                ]);

                // Update Stock
                $qtyBefore = $product->stock;
                $product->stock -= $item['qty'];
                $product->save();

                // Stock History
                StockHistory::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'adjustment',
                    'qty' => $item['qty'],
                    'qty_before' => $qtyBefore,
                    'qty_after' => $product->stock,
                    'notes' => 'Penjualan POS ' . $invoiceNo,
                    'reference_type' => 'transaction',
                    'reference_id' => $transaction->id
                ]);
            }

            $total = $subtotal - ($request->discount ?? 0);
            $change = $request->paid_amount - $total;

            if ($change < 0 && $request->payment_method == 'cash') {
                throw new \Exception("Uang bayar kurang dari total belanja!");
            }

            $transaction->update([
                'subtotal' => $subtotal,
                'total' => $total,
                'change_amount' => $change < 0 ? 0 : $change
            ]);

            DB::commit();

            return redirect()->route('pos.invoice', $transaction->id)->with('success', 'Transaksi berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function invoice(Transaction $transaction)
    {
        $transaction->load(['items.product', 'customer', 'user']);
        return view('pos.invoice', compact('transaction'));
    }
}
