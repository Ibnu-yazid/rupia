<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $transactions = Auth::user()->transactions()->with('category')->get();
        $expenseCategories = $transactions
            ->where('type', 'expense')
            ->groupBy(fn ($transaction) => $transaction->category->name)
            ->map(fn ($items) => $items->sum('amount'));

        $monthly = $transactions
            ->groupBy(fn ($transaction) => $transaction->transaction_date->format('Y-m'))
            ->sortKeys();

        return view('reports.index', [
            'categoryLabels' => $expenseCategories->keys()->values(),
            'categoryTotals' => $expenseCategories->values(),
            'months' => $monthly->keys()->values(),
            'incomeTotals' => $monthly->map(fn ($items) => $items->where('type', 'income')->sum('amount'))->values(),
            'expenseTotals' => $monthly->map(fn ($items) => $items->where('type', 'expense')->sum('amount'))->values(),
        ]);
    }
}
