<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $date_start = $request->has('date_start') ? $request->date_start : date('Y-m') . '-01';
        $date_end = $request->has('date_end') ? $request->date_end : date('Y-m-d');

        $old_date_start = '2019-01-01';
        $old_date_end = date('Y-m-d', strtotime('-1 day', strtotime($date_start)));
        $old_transactions_in = Transaction::where('type', 'in')->whereBetween('date', [$old_date_start, $old_date_end])->get();
        $old_transactions_out = Transaction::where('type', 'out')->whereBetween('date', [$old_date_start, $old_date_end])->get();
        $old_expenses = Expense::whereBetween('date', [$old_date_start, $old_date_end])->get();
        $old_balance = $old_transactions_in->sum('total') - $old_transactions_out->sum('total') - $old_expenses->sum('amount');

        $transactions = Transaction::with('product')->whereBetween('date', [$date_start, $date_end])->get();
        $expenses = Expense::whereBetween('date', [$date_start, $date_end])->get();

        $items = collect();
        $items = $items->merge($transactions)->merge($expenses)->sortBy('date');

        return view('reports', compact([
            'date_start', 'date_end', 'items', 'old_balance',
        ]));
    }
}
