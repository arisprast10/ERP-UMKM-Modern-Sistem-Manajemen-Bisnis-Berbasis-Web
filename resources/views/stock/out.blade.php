@extends('layouts.app')
@section('title', 'Stok Keluar')
@section('content')
<h3 class="text-3xl font-bold text-gray-800 mb-6">Input Stok Keluar</h3>
<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 max-w-2xl">
    <form action="{{ route('stock.storeOut') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Produk *</label>
                <select name="product_id" required class="mt-1 block w-full border rounded-md p-2">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->barcode }} - {{ $product->name }} (Sisa: {{ $product->stock }})</option>
                    @endforeach
                </select>
                @error('qty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Jumlah Keluar *</label>
                <input type="number" name="qty" required min="1" class="mt-1 block w-full border rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alasan / Keterangan *</label>
                <textarea name="notes" required class="mt-1 block w-full border rounded-md p-2" placeholder="Contoh: Barang rusak, expired"></textarea>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md">Simpan Stok Keluar</button>
        </div>
    </form>
</div>
@endsection