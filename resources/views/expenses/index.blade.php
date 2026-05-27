@extends('layouts.app')
@section('title', 'Manajemen Pengeluaran')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-3xl font-bold text-gray-800">Manajemen Pengeluaran</h3>
    <a href="{{ route('expenses.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">+ Tambah Pengeluaran</a>
</div>
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Keterangan</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Nominal</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $item)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($item->expense_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->description ?: '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ optional($item->category)->name ?? '-' }}</td>
                    <td class="px-6 py-4 font-bold text-red-600">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('expenses.edit', $item) }}" class="text-blue-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('expenses.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data pengeluaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t">{{ $expenses->links() }}</div>
</div>
@endsection