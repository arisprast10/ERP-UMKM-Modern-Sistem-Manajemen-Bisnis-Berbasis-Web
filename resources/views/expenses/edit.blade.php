@extends('layouts.app')
@section('title', isset($expense) ? 'Edit Pengeluaran' : 'Tambah Pengeluaran')
@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('expenses.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h3 class="text-3xl font-bold text-gray-800">{{ isset($expense) ? 'Edit Pengeluaran' : 'Tambah Pengeluaran' }}</h3>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100 max-w-xl">
    <form action="{{ isset($expense) ? route('expenses.update', $expense) : route('expenses.store') }}" method="POST" class="p-6">
        @csrf
        @if(isset($expense)) @method('PUT') @endif
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal *</label>
                <input type="date" name="expense_date" value="{{ old('expense_date', isset($expense) ? $expense->expense_date : date('Y-m-d')) }}" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                @error('expense_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori *</label>
                <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', isset($expense) ? $expense->category_id : '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Nominal (Rp) *</label>
                <input type="text" name="amount" value="{{ old('amount', isset($expense) ? $expense->amount : '') }}" required class="money-input mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">{{ old('description', isset($expense) ? $expense->description : '') }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">Simpan</button>
            <a href="{{ route('expenses.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
</div>
@endsection