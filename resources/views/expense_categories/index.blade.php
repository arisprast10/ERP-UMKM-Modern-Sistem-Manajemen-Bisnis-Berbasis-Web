@extends('layouts.app')
@section('title', 'Kategori Pengeluaran')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-800">Kategori Pengeluaran</h3>
    <a href="{{ route('expense_categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">+ Tambah Kategori</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <table class="w-full text-sm text-left">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-3">Nama Kategori</th>
                <th class="px-6 py-3">Jumlah Pengeluaran</th>
                <th class="px-6 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $item->name }}</td>
                <td class="px-6 py-4">{{ $item->expenses_count }} data</td>
                <td class="px-6 py-4 text-right space-x-3">
                    <a href="{{ route('expense_categories.edit', $item) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('expense_categories.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">{{ $categories->links() }}</div>
</div>
@endsection