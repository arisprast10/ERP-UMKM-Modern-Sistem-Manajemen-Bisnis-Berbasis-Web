<?php
namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::withCount('expenses')->paginate(15);
        return view('expense_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('expense_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        ExpenseCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);
        return redirect()->route('expense_categories.index')->with('success', 'Kategori Pengeluaran ditambahkan.');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('expense_categories.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $request->validate(['name' => 'required|string|max:255', 'description' => 'nullable|string']);
        $expenseCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description
        ]);
        return redirect()->route('expense_categories.index')->with('success', 'Kategori Pengeluaran diperbarui.');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->expenses()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan di data pengeluaran.');
        }
        $expenseCategory->delete();
        return redirect()->route('expense_categories.index')->with('success', 'Kategori Pengeluaran dihapus.');
    }
}
