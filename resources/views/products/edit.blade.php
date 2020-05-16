@extends('layouts.app')

@section('title')
Edit Barang - {{ $product->name }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Barang</div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="code" class="col-md-4 col-form-label text-md-right">Kode Barang</label>
                            <div class="col-sm-4">
                                <input type="text" name="code" id="code" class="form-control" required
                                    value="{{ $product->code }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nama Barang</label>
                            <div class="col-sm">
                                <input type="text" name="name" id="name" class="form-control" required
                                    value="{{ $product->name }}">
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
                                        value="{{ $product->price }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.card -->
        </div>
    </div>
</div>
@endsection