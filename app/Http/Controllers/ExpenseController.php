<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with(['category', 'user'])->latest()->paginate(15);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::all();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'category_id'  => 'required|exists:expense_categories,id',
            'amount'       => 'required|numeric|min:1',
            'description'  => 'nullable|string|max:500',
        ]);

        Expense::create([
            'expense_date' => $request->expense_date,
            'category_id'  => $request->category_id,
            'amount'       => $request->amount,
            'description'  => $request->description,
            'user_id'      => auth()->id(),
        ]);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::all();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'category_id'  => 'required|exists:expense_categories,id',
            'amount'       => 'required|numeric|min:1',
            'description'  => 'nullable|string|max:500',
        ]);

        $expense->update([
            'expense_date' => $request->expense_date,
            'category_id'  => $request->category_id,
            'amount'       => $request->amount,
            'description'  => $request->description,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
