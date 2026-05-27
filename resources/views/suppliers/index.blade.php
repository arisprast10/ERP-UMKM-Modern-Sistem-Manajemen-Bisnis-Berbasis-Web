@extends('layouts.app')
@section('title', 'Manajemen Supplier')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-800">Manajemen Supplier</h3>
    <a href="{{ route('suppliers.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">+ Tambah Supplier</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Nama Supplier</th>
                    <th class="px-6 py-3">Kontak Person</th>
                    <th class="px-6 py-3">No. Telepon</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $i => $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $suppliers->firstItem() + $i }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->contact_person ?: '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->phone ?: '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $item->email ?: '-' }}</td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('suppliers.edit', $item) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('suppliers.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus supplier ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data supplier.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t">{{ $suppliers->links() }}</div>
</div>
@endsection