@extends('layouts.app')

@section('title')
Detail Barang - {{ $product->name }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detail Barang</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right">Kode Barang</label>
                        <div class="col-sm-4">
                            <input type="text" name="code" id="code" class="form-control" required
                                value="{{ $product->code }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Nama Barang</label>
                        <div class="col-sm">
                            <input type="text" name="name" id="name" class="form-control" required
                                value="{{ $product->name }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-md-4 col-form-label text-md-right">Harga Jual</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" name="price" id="price" class="form-control" required
                                    value="{{ rupiah($product->price, false) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="stock" class="col-md-4 col-form-label text-md-right">Sisa Stok</label>
                        <div class="col-md-2">
                            <input type="text" name="stock" id="stock" class="form-control" required
                                value="{{ $product->total_stock }}" readonly>
                        </div>
                    </div>
                </div>
            </div><!-- /.card -->
            <div class="card mt-4">
                <div class="card-header">Detail Stok</div>
                <div class="card-body">
                    @if ($product->total_stock > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <th class="text-right">Harga Beli</th>
                                <th class="text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($product->stocks as $stock)
                        @if ($stock->stock > 0)                            
                        <tr>
                            <td>{{ $stock->transaction->date }}</td>
                            <td class="text-right">{{ rupiah($stock->purchase_price) }}</td>
                            <td class="text-center">{{ $stock->stock }}</td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center">Stok kosong.</div>
                    @endif
                </div>
            </div><!-- /.card -->
        </div>
    </div>
</div>
@endsection