@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-3xl font-bold text-gray-800">Manajemen Produk</h3>
        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
            + Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
        <div class="p-4 border-b">
            <form action="{{ route('products.index') }}" method="GET" class="flex max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau barcode..." class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 border p-2">
                <button type="submit" class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-200">Cari</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $product->barcode }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded mr-3">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded mr-3 flex items-center justify-center text-gray-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                                    @endif
                                    {{ $product->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ optional($product->category)->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="{{ $product->stock <= $product->min_stock ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($product->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t">
            {{ $products->links() }}
        </div>
    </div>
@endsection
