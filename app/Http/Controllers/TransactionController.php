<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'user'])->latest();
        
        if ($request->search) {
            $query->where('invoice_no', 'like', "%{$request->search}%");
        }
        
        $transactions = $query->paginate(15);
        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['items.product', 'customer', 'user']);
        return view('transactions.show', compact('transaction'));
    }
}
