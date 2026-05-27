<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Stats
        $salesToday = Transaction::whereDate('created_at', $today)->where('status', 'completed')->sum('total');
        $transactionsToday = Transaction::whereDate('created_at', $today)->where('status', 'completed')->count();
        $totalProducts = Product::where('is_active', true)->count();
        $monthlyIncome = Transaction::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status', 'completed')->sum('total');

        // Low stock
        $lowStockProducts = Product::whereColumn('stock', '<', 'min_stock')->where('is_active', true)->get();

        // Top 5 selling products
        $topProducts = TransactionItem::select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->with('product')
            ->get();

        // 30 days sales chart data
        $chartLabels30 = [];
        $chartData30 = [];
        $chartLabels7 = [];
        $chartData7 = [];
        
        $transactions30 = Transaction::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
        ->where('status', 'completed')
        ->where('created_at', '>=', Carbon::today()->subDays(29))
        ->groupBy('date')
        ->pluck('total', 'date')->toArray();

        for ($i = 29; $i >= 0; $i--) {
            $dateObj = Carbon::today()->subDays($i);
            $dateStr = $dateObj->format('Y-m-d');
            
            $chartLabels30[] = $dateObj->format('d M');
            $chartData30[] = $transactions30[$dateStr] ?? 0;
            
            if ($i <= 6) {
                $chartLabels7[] = $dateObj->format('d M');
                $chartData7[] = $transactions30[$dateStr] ?? 0;
            }
        }

        return view('dashboard.index', compact(
            'salesToday', 'transactionsToday', 'totalProducts', 'monthlyIncome', 
            'lowStockProducts', 'topProducts', 'chartLabels7', 'chartData7', 'chartLabels30', 'chartData30'
        ));
    }
}
