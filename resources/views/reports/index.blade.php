@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('content')
<div class="flex justify-between items-center mb-6 print:hidden">
    <h3 class="text-3xl font-bold text-gray-800">Laporan Penjualan</h3>
    <button onclick="window.print()" class="px-5 py-2 bg-indigo-700 text-white rounded-lg shadow flex items-center font-medium hover:bg-indigo-800">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Cetak PDF
    </button>
</div>

<div id="print-area" class="print-container">
    <!-- Header Print Professional -->
    <div class="hidden print:flex justify-between items-center border-b-2 border-black pb-4 mb-6">
        <div class="flex items-center">
            @if(isset($storeSetting) && $storeSetting->store_logo)
                <img src="{{ asset('storage/' . $storeSetting->store_logo) }}" class="h-16 w-16 object-contain mr-4" alt="Logo">
            @endif
            <div>
                <h2 class="text-2xl font-bold uppercase text-black tracking-wide">{{ $storeSetting->store_name ?? 'Laporan Penjualan' }}</h2>
                <p class="text-sm text-gray-800">{{ $storeSetting->store_address ?? 'Alamat Toko' }}</p>
                <p class="text-sm text-gray-800">Telp: {{ $storeSetting->store_phone ?? '-' }}</p>
            </div>
        </div>
        <div class="text-right">
            <h1 class="text-xl font-bold uppercase text-gray-800 mb-1">Laporan Penjualan</h1>
            <p class="text-sm text-gray-800">Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
            <p class="text-sm text-gray-800">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6 print:hidden">
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700">Mulai Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="mt-1 block rounded-md border-gray-300 shadow-sm p-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="mt-1 block rounded-md border-gray-300 shadow-sm p-2 border">
            </div>
            <div>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Tampilkan</button>
            </div>
        </form>
    </div>

    <!-- Summary Box untuk Print -->
    <div class="hidden print:block mb-6 border border-black p-4">
        <div class="grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="text-sm font-bold text-gray-600 uppercase">Total Transaksi</p>
                <p class="text-lg font-bold text-black">{{ $totalTransactions }}</p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-600 uppercase">Total Diskon</p>
                <p class="text-lg font-bold text-black">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-600 uppercase">Pendapatan Bersih</p>
                <p class="text-lg font-bold text-black">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 print:hidden">
        <x-stat-card title="Total Transaksi" value="{{ $totalTransactions }}" icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>' color="blue" />
        <x-stat-card title="Total Diskon Diberikan" value="Rp {{ number_format($totalDiscount, 0, ',', '.') }}" icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' color="red" />
        <x-stat-card title="Total Pendapatan Bersih" value="Rp {{ number_format($totalSales, 0, ',', '.') }}" icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' color="green" />
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden print:border-0 print:shadow-none">
        <table class="min-w-full divide-y divide-gray-200 print:border-collapse print:border print:border-black">
            <thead class="bg-gray-50 print:bg-gray-200">
                <tr class="print:border-b print:border-black">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase print:text-black print:border-r print:border-black">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase print:text-black print:border-r print:border-black">No. Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase print:text-black print:border-r print:border-black">Kasir</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase print:text-black">Total (Rp)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 print:divide-black">
                @forelse($transactions as $t)
                <tr class="print:border-b print:border-black">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 print:text-black print:border-r print:border-black">{{ $t->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 print:text-black print:border-r print:border-black">{{ $t->invoice_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 print:text-black print:border-r print:border-black">{{ optional($t->user)->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium print:text-black">{{ number_format($t->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 print:text-black">Tidak ada transaksi di periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="hidden print:block mt-10 text-right mr-10">
        <p class="mb-16">Mengetahui,</p>
        <p class="font-bold border-t border-black inline-block pt-1 uppercase">{{ optional(auth()->user())->name ?? 'Admin' }}</p>
    </div>
</div>

<style>
    @media print {
        @page { margin: 1cm; size: A4 portrait; }
        body { font-family: 'Times New Roman', Times, serif; color: black; }
        .print\:border-black { border-color: black !important; }
        .print\:text-black { color: black !important; }
        .print\:bg-gray-200 { background-color: #e5e7eb !important; -webkit-print-color-adjust: exact; }
    }
</style>
@endsection