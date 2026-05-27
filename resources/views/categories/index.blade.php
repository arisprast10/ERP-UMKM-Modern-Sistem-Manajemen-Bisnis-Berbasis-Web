@extends('layouts.app')
@section('title', 'Manajemen Kategori')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-800">Manajemen Kategori</h3>
    <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">+ Tambah Kategori</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nama Kategori</th>
                    <th class="px-6 py-3">Slug</th>
                    <th class="px-6 py-3">Jumlah Produk</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $categories->firstItem() + $i }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $item->slug }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $item->products->count() }}</td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('categories.edit', $item) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('categories.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t">{{ $categories->links() }}</div>
</div>
@endsection