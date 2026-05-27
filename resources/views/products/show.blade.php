@extends('layouts.app')
@section('title', 'Detail Produk')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h3 class="text-3xl font-bold text-gray-800">Detail Produk</h3>
        </div>
        <div>
            <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informasi -->
        <div class="md:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-xl font-bold text-gray-900">{{ $product->name }}</h4>
                        <p class="text-sm text-gray-500 mt-1">Kategori: {{ optional($product->category)->name ?? '-' }}</p>
                    </div>
                    @if($product->is_active)
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                    @endif
                </div>
            </div>
            
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Harga Modal</span>
                    <span class="block text-lg text-gray-900 mt-1">Rp {{ number_format($product->buy_price, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Harga Jual</span>
                    <span class="block text-lg font-bold text-indigo-600 mt-1">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Sisa Stok</span>
                    <span class="block text-lg text-gray-900 mt-1 {{ $product->stock <= $product->min_stock ? 'text-red-600 font-bold' : '' }}">{{ $product->stock }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Batas Stok Minimum</span>
                    <span class="block text-lg text-gray-900 mt-1">{{ $product->min_stock }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Deskripsi</span>
                    <p class="mt-1 text-sm text-gray-900">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>
                </div>
            </div>
        </div>

        <!-- Gambar dan Barcode -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden p-6 flex flex-col items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-auto max-h-48 object-cover rounded mb-4">
                @else
                    <div class="w-full h-48 bg-gray-100 rounded mb-4 flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">Tidak ada gambar</p>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden p-6 text-center">
                <h4 class="text-sm font-medium text-gray-500 mb-4">Barcode Produk</h4>
                <div class="inline-block p-4 bg-white border border-dashed border-gray-300 rounded">
                    {!! DNS1D::getBarcodeHTML($product->barcode, 'C128', 2, 60) !!}
                    <p class="mt-2 text-lg tracking-widest font-mono text-gray-800">{{ $product->barcode }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
