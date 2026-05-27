@extends('layouts.app')
@section('title', isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier')
@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('suppliers.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h3 class="text-3xl font-bold text-gray-800">{{ isset($supplier) ? 'Edit Supplier' : 'Tambah Supplier' }}</h3>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100 max-w-xl">
    <form action="{{ isset($supplier) ? route('suppliers.update', $supplier) : route('suppliers.store') }}" method="POST" class="p-6">
        @csrf
        @if(isset($supplier)) @method('PUT') @endif
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Supplier *</label>
                <input type="text" name="name" value="{{ old('name', isset($supplier) ? $supplier->name : '') }}" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kontak Person</label>
                <input type="text" name="contact_person" value="{{ old('contact_person', isset($supplier) ? $supplier->contact_person : '') }}" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', isset($supplier) ? $supplier->phone : '') }}" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', isset($supplier) ? $supplier->email : '') }}" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500">{{ old('address', isset($supplier) ? $supplier->address : '') }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex items-center space-x-3">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">Simpan</button>
            <a href="{{ route('suppliers.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
        </div>
    </form>
</div>
@endsection