@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
    <div class="flex items-center mb-6">
        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h3 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h3>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Kiri -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori *</label>
                        <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga Modal (Rp) *</label>
                            <input type="text" name="buy_price" value="{{ old('buy_price') }}" required class="money-input mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('buy_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Harga Jual (Rp) *</label>
                            <input type="text" name="sell_price" value="{{ old('sell_price') }}" required class="money-input mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('sell_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stok Awal *</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Batas Stok Minimum *</label>
                            <input type="number" name="min_stock" value="{{ old('min_stock', 5) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('min_stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Kanan -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                        <input type="file" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center mt-4">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Produk Aktif (Tampil di Kasir)
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-200 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 shadow-sm">Simpan Produk</button>
            </div>
        </form>
    </div>
@endsection
