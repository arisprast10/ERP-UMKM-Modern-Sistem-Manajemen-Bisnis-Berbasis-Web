@extends('layouts.app')
@section('title', 'Histori Stok')
@section('content')
<div class="flex justify-between items-center mb-6 print:hidden">
    <h3 class="text-3xl font-bold text-gray-800">Histori Stok</h3>
    <div class="space-x-2 flex items-center">
        <a href="{{ route('stock.in') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">+ Stok Masuk</a>
        <a href="{{ route('stock.out') }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium">- Stok Keluar</a>
        <button onclick="window.print()" class="px-4 py-2 bg-indigo-700 text-white rounded-md shadow flex items-center font-medium hover:bg-indigo-800 ml-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak PDF
        </button>
    </div>
</div>

<div id="print-area" class="print-container">
    <!-- Header Print Professional -->
    <div class="hidden print:flex justify-between items-center border-b-2 border-black pb-4 mb-6">
        <div class="flex items-center">
            @if(isset($storeSetting) && $storeSetting->store_logo)
                <img src="{{ asset('storage/' . $storeSetting->store_logo) }}" class="h-16 w-16 object-contain mr-4" alt="Logo">
            @endif
            <div>
                <h2 class="text-2xl font-bold uppercase text-black tracking-wide">{{ $storeSetting->store_name ?? 'ERP UMKM' }}</h2>
                <p class="text-sm text-gray-800">{{ $storeSetting->store_address ?? 'Alamat Toko' }}</p>
                <p class="text-sm text-gray-800">Telp: {{ $storeSetting->store_phone ?? '-' }}</p>
            </div>
        </div>
        <div class="text-right">
            <h1 class="text-xl font-bold uppercase text-gray-800 mb-1">Laporan Histori Stok</h1>
            <p class="text-sm text-gray-800">Filter: {{ request('type') == 'in' ? 'Stok Masuk' : (request('type') == 'out' ? 'Stok Keluar' : (request('type') == 'adjustment' ? 'Penyesuaian (POS)' : 'Semua Tipe')) }}</p>
            <p class="text-sm text-gray-800">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6 print:border-0 print:shadow-none">
        <div class="p-4 border-b print:hidden">
            <form action="{{ route('stock.index') }}" method="GET" class="flex max-w-sm">
                <select name="type" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 border p-2">
                    <option value="">Semua Tipe</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stok Masuk</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stok Keluar</option>
                    <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Penyesuaian (POS)</option>
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left print:border-collapse print:border print:border-black">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b print:bg-gray-200 print:border-black">
                    <tr>
                        <th class="px-6 py-3 print:text-black print:border-r print:border-black">Tanggal</th>
                        <th class="px-6 py-3 print:text-black print:border-r print:border-black">Produk</th>
                        <th class="px-6 py-3 print:text-black print:border-r print:border-black">Tipe</th>
                        <th class="px-6 py-3 print:text-black print:border-r print:border-black">Jumlah</th>
                        <th class="px-6 py-3 print:text-black print:border-r print:border-black">Stok Akhir</th>
                        <th class="px-6 py-3 print:text-black print:border-r print:border-black">Keterangan</th>
                        <th class="px-6 py-3 print:text-black">Oleh</th>
                    </tr>
                </thead>
                <tbody class="print:divide-black">
                    @forelse($histories as $history)
                    <tr class="bg-white border-b hover:bg-gray-50 print:border-black">
                        <td class="px-6 py-4 print:text-black print:border-r print:border-black">{{ $history->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 print:text-black print:border-r print:border-black">{{ $history->product->name }}</td>
                        <td class="px-6 py-4 print:text-black print:border-r print:border-black">
                            @if($history->type == 'in') <span class="text-green-600 font-bold print:text-black">Masuk</span>
                            @elseif($history->type == 'out') <span class="text-red-600 font-bold print:text-black">Keluar</span>
                            @else <span class="text-blue-600 font-bold print:text-black">POS</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 print:text-black print:border-r print:border-black">{{ $history->qty }}</td>
                        <td class="px-6 py-4 print:text-black print:border-r print:border-black">{{ $history->qty_after }}</td>
                        <td class="px-6 py-4 text-gray-500 print:text-black print:border-r print:border-black">{{ $history->notes ?: '-' }}</td>
                        <td class="px-6 py-4 text-gray-500 print:text-black">{{ optional($history->user)->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-4 text-center print:text-black">Belum ada histori stok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t print:hidden">{{ $histories->links() }}</div>
    </div>
    
    <div class="hidden print:block mt-10 text-right mr-10">
        <p class="mb-16">Mengetahui,</p>
        <p class="font-bold border-t border-black inline-block pt-1 uppercase">{{ optional(auth()->user())->name ?? 'Admin' }}</p>
    </div>
</div>

<style>
    @media print {
        @page { margin: 1cm; size: A4 landscape; }
        body { font-family: 'Times New Roman', Times, serif; color: black; }
        .print\:border-black { border-color: black !important; }
        .print\:text-black { color: black !important; }
        .print\:bg-gray-200 { background-color: #e5e7eb !important; -webkit-print-color-adjust: exact; }
        .shadow-sm { box-shadow: none !important; border: none !important; }
    }
</style>
@endsection