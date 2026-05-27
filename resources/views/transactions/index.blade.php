@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('content')
<h3 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Transaksi</h3>
<div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
    <div class="p-4 border-b">
        <form action="{{ route('transactions.index') }}" method="GET" class="flex max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No Invoice..." class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-indigo-300 border p-2">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-r-md">Cari</button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">Waktu</th>
                    <th class="px-6 py-3">No. Invoice</th>
                    <th class="px-6 py-3">Kasir</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 font-bold text-indigo-600">{{ $trx->invoice_no }}</td>
                    <td class="px-6 py-4">{{ $trx->user->name }}</td>
                    <td class="px-6 py-4">{{ optional($trx->customer)->name ?? 'Umum' }}</td>
                    <td class="px-6 py-4 font-bold">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('transactions.show', $trx) }}" class="text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('pos.invoice', $trx) }}" class="text-gray-600 hover:underline">Struk</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-4 text-center">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $transactions->links() }}</div>
</div>
@endsection