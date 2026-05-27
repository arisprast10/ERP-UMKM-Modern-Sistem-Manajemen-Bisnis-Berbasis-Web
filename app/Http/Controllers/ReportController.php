<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfMonth();

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();
            
        $totalSales = $transactions->sum('total');
        $totalDiscount = $transactions->sum('discount');
        $totalTransactions = $transactions->count();

        return view('reports.index', compact('transactions', 'totalSales', 'totalDiscount', 'totalTransactions', 'startDate', 'endDate'));
    }
}
