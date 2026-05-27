@extends('layouts.app')
@section('title', 'Invoice ' . $transaction->invoice_no)
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6 print:hidden">
        <a href="{{ route('pos.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Kasir
        </a>
        <button onclick="window.print()" class="px-5 py-2 bg-indigo-700 text-white rounded-lg shadow flex items-center font-medium hover:bg-indigo-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Struk
        </button>
    </div>

    <div id="struk" class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
        <!-- Header Toko -->
        <div class="text-center mb-6 border-b border-dashed border-gray-300 pb-5">
            @if($storeSetting->store_logo)
                <img src="{{ asset('storage/' . $storeSetting->store_logo) }}" class="h-16 w-auto object-contain mx-auto mb-3" alt="Logo Toko">
            @endif
            <h2 class="text-2xl font-extrabold text-gray-900 uppercase tracking-widest">{{ $storeSetting->store_name ?? 'TOKO UMKM' }}</h2>
            @if($storeSetting->store_address)
                <p class="text-sm text-gray-500 mt-1">{{ $storeSetting->store_address }}</p>
            @endif
            @if($storeSetting->store_phone)
                <p class="text-sm text-gray-500">Telp: {{ $storeSetting->store_phone }}</p>
            @endif
            <p class="text-xs text-gray-400 mt-2 uppercase tracking-widest">— Struk Pembelian —</p>
        </div>

        <!-- Info Transaksi -->
        <div class="flex justify-between mb-6 text-sm">
            <div class="space-y-1">
                <p class="text-gray-500">No. Invoice</p>
                <p class="font-bold text-gray-900">{{ $transaction->invoice_no }}</p>
                <p class="text-gray-500 mt-2">Tanggal</p>
                <p class="font-medium text-gray-800">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="text-right space-y-1">
                <p class="text-gray-500">Kasir</p>
                <p class="font-medium text-gray-800">{{ $transaction->user->name }}</p>
                <p class="text-gray-500 mt-2">Pelanggan</p>
                <p class="font-medium text-gray-800">{{ optional($transaction->customer)->name ?? 'Umum' }}</p>
            </div>
        </div>

        <!-- Items -->
        <table class="w-full mb-6 text-sm">
            <thead>
                <tr class="border-y border-dashed border-gray-300 text-gray-500">
                    <th class="py-2 text-left font-semibold">Produk</th>
                    <th class="py-2 text-center font-semibold">Qty</th>
                    <th class="py-2 text-right font-semibold">Harga</th>
                    <th class="py-2 text-right font-semibold">Subtotal</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @foreach($transaction->items as $item)
                <tr class="border-b border-gray-100">
                    <td class="py-2 font-medium">{{ optional($item->product)->name ?? 'Produk dihapus' }}</td>
                    <td class="py-2 text-center">{{ $item->qty }}</td>
                    <td class="py-2 text-right">{{ number_format($item->sell_price, 0, ',', '.') }}</td>
                    <td class="py-2 text-right font-semibold">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="border-t border-dashed border-gray-300 pt-4">
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($transaction->discount > 0)
            <div class="flex justify-between text-sm text-red-500 mb-1">
                <span>Diskon</span>
                <span>- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between text-lg font-extrabold text-gray-900 border-t border-dashed border-gray-300 pt-3 mt-2">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mt-2">
                <span>Bayar ({{ ucfirst($transaction->payment_method) }})</span>
                <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm font-semibold text-green-700">
                <span>Kembali</span>
                <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 pt-4 border-t border-dashed border-gray-300 text-center text-xs text-gray-400">
            <p class="font-medium text-gray-600 mb-1">Terima kasih atas kunjungan Anda! 🙏</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
            <p class="mt-1">{{ $storeSetting->store_name ?? '' }} &bull; {{ now()->format('Y') }}</p>
        </div>
    </div>
</div>

<style>
    @media print {
        body { margin: 0; }
        body > * { display: none; }
        #struk { display: block !important; visibility: visible !important; position: absolute; top: 0; left: 0; width: 100%; max-width: 400px; margin: 0 auto; padding: 20px; box-shadow: none !important; border: none !important; }
        .print\:hidden { display: none !important; }
    }
</style>
@endsection