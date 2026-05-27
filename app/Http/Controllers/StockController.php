<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockHistory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = StockHistory::with(['product', 'user'])->latest();
        
        if ($request->type) {
            $query->where('type', $request->type);
        }
        
        $histories = $query->paginate(15);
        return view('stock.index', compact('histories'));
    }

    public function createIn()
    {
        $products = Product::where('is_active', true)->get();
        $suppliers = Supplier::all();
        return view('stock.in', compact('products', 'suppliers'));
    }

    public function storeIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'notes' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::lockForUpdate()->findOrFail($request->product_id);
            $qtyBefore = $product->stock;
            $product->stock += $request->qty;
            $product->save();

            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'in',
                'qty' => $request->qty,
                'qty_before' => $qtyBefore,
                'qty_after' => $product->stock,
                'notes' => $request->notes,
                'reference_type' => $request->supplier_id ? 'supplier' : null,
                'reference_id' => $request->supplier_id
            ]);
        });

        return redirect()->route('stock.index')->with('success', 'Stok masuk berhasil dicatat.');
    }

    public function createOut()
    {
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('stock.out', compact('products'));
    }

    public function storeOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'notes' => 'required|string'
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::lockForUpdate()->findOrFail($request->product_id);
            
            if ($product->stock < $request->qty) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'qty' => ['Stok produk tidak mencukupi. Sisa stok: ' . $product->stock]
                ]);
            }

            $qtyBefore = $product->stock;
            $product->stock -= $request->qty;
            $product->save();

            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'out',
                'qty' => $request->qty,
                'qty_before' => $qtyBefore,
                'qty_after' => $product->stock,
                'notes' => $request->notes
            ]);
        });

        return redirect()->route('stock.index')->with('success', 'Stok keluar berhasil dicatat.');
    }
}
