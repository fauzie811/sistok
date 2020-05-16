@extends('layouts.app')

@section('title')
Detail Barang Masuk - #{{ $transaction->id }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detail Barang Masuk</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" name="date" id="date" class="form-control" required
                                    value="{{ $transaction->date }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Kode Barang</label>
                        <div class="col-sm-4">
                            <input type="text" name="description" id="description" class="form-control" required
                                value="{{ $transaction->product->code }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">Nama Barang</label>
                        <div class="col-sm">
                            <input type="text" name="description" id="description" class="form-control" required
                                value="{{ $transaction->product->name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-right">Harga Beli Satuan</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" name="amount" id="amount" class="form-control" required
                                    value="{{ rupiah($transaction->price, false) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-right">Jumlah</label>
                        <div class="col-md-2">
                            <input type="text" name="amount" id="amount" class="form-control" required
                                value="{{ $transaction->quantity }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-right">Total Harga</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" name="amount" id="amount" class="form-control" required
                                    value="{{ rupiah($transaction->total, false) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.card -->
        </div>
    </div>
</div>
@endsection