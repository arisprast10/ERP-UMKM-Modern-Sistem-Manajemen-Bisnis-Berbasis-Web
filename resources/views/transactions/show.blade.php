@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('transactions.index') }}" class="text-gray-500 hover:text-gray-700 mr-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    </a>
    <h3 class="text-3xl font-bold text-gray-800">Detail Transaksi: {{ $transaction->invoice_no }}</h3>
</div>
<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p class="text-sm text-gray-500">Tanggal Transaksi</p>
            <p class="font-medium text-gray-900">{{ $transaction->created_at->format('d F Y, H:i:s') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Metode Pembayaran</p>
            <p class="font-medium text-gray-900">{{ strtoupper($transaction->payment_method) }}</p>
        </div>
    </div>
    <table class="w-full text-sm text-left mb-6 border">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-2 border-r">Produk</th>
                <th class="px-4 py-2 border-r text-center">Qty</th>
                <th class="px-4 py-2 border-r text-right">Harga</th>
                <th class="px-4 py-2 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $item)
            <tr class="border-b">
                <td class="px-4 py-2 border-r">{{ optional($item->product)->name ?? 'Produk Dihapus' }}</td>
                <td class="px-4 py-2 border-r text-center">{{ $item->qty }}</td>
                <td class="px-4 py-2 border-r text-right">Rp {{ number_format($item->sell_price, 0, ',', '.') }}</td>
                <td class="px-4 py-2 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="font-bold bg-gray-50">
            <tr>
                <td colspan="3" class="px-4 py-2 text-right border-r">Diskon</td>
                <td class="px-4 py-2 text-right text-red-600">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="px-4 py-2 text-right border-r">Total Akhir</td>
                <td class="px-4 py-2 text-right text-indigo-600 text-lg">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection