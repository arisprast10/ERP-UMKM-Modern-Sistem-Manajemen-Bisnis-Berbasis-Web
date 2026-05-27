@extends('layouts.app')
@section('title', isset($expenseCategory) ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')
<h3 class="text-3xl font-bold text-gray-800 mb-6">{{ isset($expenseCategory) ? 'Edit Kategori' : 'Tambah Kategori' }}</h3>
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 max-w-xl">
    <form action="{{ isset($expenseCategory) ? route('expense_categories.update', $expenseCategory) : route('expense_categories.store') }}" method="POST">
        @csrf @if(isset($expenseCategory)) @method('PUT') @endif
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $expenseCategory->name ?? '') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 p-2 border">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 p-2 border">{{ old('description', $expenseCategory->description ?? '') }}</textarea>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('expense_categories.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection