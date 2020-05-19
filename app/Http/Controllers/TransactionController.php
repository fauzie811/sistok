<?php

namespace App\Http\Controllers;

use App\Product;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->has('type') ? $request->type : 'in';
        $transactions = Transaction::with('product')->where('type', $type)->get();
        return view("transactions.{$type}.index", compact(['transactions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => ['required', 'in:in,out'],
            'date' => ['nullable', 'date'],
            'product_id' => ['required', 'exists:products,id'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        if ($request->get('type') == 'out') {
            $product = Product::with('totalStock')->find($request->get('product_id'));
            if ($product->total_stock < $request->get('quantity')) {
                return \redirect()->back()->withErrors([
                    'stock_not_enough' => '<strong>Stok barang tidak mencukupi.</strong> Sisa stok: ' . $product->total_stock,
                ]);
            }
        }
        Transaction::create($request->only(['type', 'date', 'product_id', 'price', 'quantity']));

        return \redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if ($transaction->type == 'out') {
            $transaction->load(['details', 'details.stock']);
        } else {
            $transaction->load(['stock', 'stock.details']);
        }
        
        return view("transactions.{$transaction->type}.show", compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->type == 'out' || sizeof($transaction->stock->details) > 0) {
            return \redirect()->back()->withErrors([
                'transaction_not_editable' => 'Data transaksi sudah tidak bisa diedit.'
            ]);
        }

        return view("transactions.{$transaction->type}.edit", compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->type == 'out' || sizeof($transaction->stock->details) > 0) {
            return \redirect()->back()->withErrors([
                'transaction_not_editable' => 'Data transaksi sudah tidak bisa diedit.'
            ]);
        }
        $this->validate($request, [
            'date' => ['nullable', 'date'],
            'product_id' => ['nullable', 'exists:products,id'],
            'price' => ['nullable', 'numeric'],
            'quantity' => ['nullable', 'numeric'],
        ]);

        if ($transaction->type == 'in') {
            $transaction->update($request->only(['date', 'product_id', 'price', 'quantity']));
        }

        return \redirect()->route('transactions.show', $transaction->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->type == 'in' && sizeof($transaction->stock->details) > 0) {
            return \redirect()->back()->withErrors([
                'transaction_not_deleteable' => 'Data transaksi sudah tidak bisa dihapus.'
            ]);
        }
        if ($transaction->type == 'in') {
            $transaction->stock->delete();
        } else {
            foreach ($transaction->details as $detail) {
                $detail->stock->update([
                    'stock' => $detail->stock->stock + $detail->quantity,
                ]);
                $detail->delete();
            }
        }
        $transaction->delete();

        return redirect()->back();
    }
}
