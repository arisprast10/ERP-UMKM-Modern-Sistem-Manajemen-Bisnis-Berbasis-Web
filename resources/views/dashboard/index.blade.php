@extends('layouts.app')
@section('title', 'Dashboard Analytics')

@section('content')
    <h3 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Penjualan Hari Ini" 
            value="Rp {{ number_format($salesToday, 0, ',', '.') }}" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            color="green" 
        />
        <x-stat-card 
            title="Transaksi Hari Ini" 
            value="{{ $transactionsToday }}" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
            color="indigo" 
        />
        <x-stat-card 
            title="Total Produk Aktif" 
            value="{{ $totalProducts }}" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>'
            color="blue" 
        />
        <x-stat-card 
            title="Pemasukan Bulan Ini" 
            value="Rp {{ number_format($monthlyIncome, 0, ',', '.') }}" 
            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>'
            color="purple" 
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sales Chart -->
        <div class="bg-white p-6 rounded-lg shadow-sm lg:col-span-2 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-gray-700" id="chart-title">Grafik Penjualan 7 Hari Terakhir</h4>
                <div class="flex bg-gray-100 rounded-lg p-1 gap-1">
                    <button id="btn-7" onclick="switchChart(7)" 
                        class="px-4 py-1.5 text-sm font-medium rounded-md bg-indigo-600 text-white shadow transition-all">
                        7 Hari
                    </button>
                    <button id="btn-30" onclick="switchChart(30)" 
                        class="px-4 py-1.5 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition-all">
                        30 Hari
                    </button>
                </div>
            </div>
            <div class="relative h-72">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Low Stock -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h4 class="text-lg font-semibold text-red-600 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Stok Menipis
                </h4>
                @if($lowStockProducts->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($lowStockProducts as $product)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-gray-700 font-medium text-sm">{{ $product->name }}</span>
                                <span class="px-2 py-1 text-xs font-bold rounded bg-red-100 text-red-700">{{ $product->stock }} tersisa</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">Semua stok produk aman.</p>
                @endif
            </div>

            <!-- Top Products -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h4 class="text-lg font-semibold text-indigo-600 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    Produk Terlaris
                </h4>
                @if($topProducts->count() > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($topProducts as $top)
                            <li class="py-3 flex justify-between items-center">
                                <span class="text-gray-700 font-medium text-sm">{{ $top->product ? $top->product->name : 'Produk Dihapus' }}</span>
                                <span class="text-gray-600 text-sm font-semibold">{{ $top->total_qty }} terjual</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">Belum ada data penjualan.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        const chartLabels7  = {!! json_encode($chartLabels7) !!};
        const chartData7    = {!! json_encode($chartData7) !!};
        const chartLabels30 = {!! json_encode($chartLabels30) !!};
        const chartData30   = {!! json_encode($chartData30) !!};

        let salesChart;
        let currentPeriod = 7;

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels7,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: chartData7,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#4f46e5',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                                    if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'rb';
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });

        function switchChart(days) {
            if (days === currentPeriod) return;
            currentPeriod = days;

            const labels = days === 7 ? chartLabels7 : chartLabels30;
            const data   = days === 7 ? chartData7   : chartData30;

            salesChart.data.labels = labels;
            salesChart.data.datasets[0].data = data;
            salesChart.update('active');

            document.getElementById('chart-title').textContent =
                'Grafik Penjualan ' + days + ' Hari Terakhir';

            // toggle button styles
            const active   = document.getElementById('btn-' + days);
            const inactive = document.getElementById('btn-' + (days === 7 ? 30 : 7));
            active.className   = 'px-4 py-1.5 text-sm font-medium rounded-md bg-indigo-600 text-white shadow transition-all';
            inactive.className = 'px-4 py-1.5 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition-all';
        }
    </script>
@endsection
