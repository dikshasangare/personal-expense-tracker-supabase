<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalIncome = $user->transactions()
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = $user->transactions()
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        $currentMonthIncome = $user->transactions()
            ->where('type', 'income')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $currentMonthExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $recentTransactions = $user->transactions()
            ->with('category')
            ->latest('transaction_date')
            ->latest('id')
            ->limit(5)
            ->get();

        $categoryExpenses = $user->transactions()
            ->select(
                'category_id',
                DB::raw('SUM(amount) as total')
            )
            ->with('category')
            ->where('type', 'expense')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'balance',
            'currentMonthIncome',
            'currentMonthExpense',
            'recentTransactions',
            'categoryExpenses'
        ));
    }
}
