@extends('layouts.app')

@section('title')
Data Barang - {{ date('Y-m-d') }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Data Barang</div>
                <div class="card-body">
                    @if (sizeof($products) > 0)
                    <table class="datatable table mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th class="text-nowrap text-right">Harga Jual</th>
                                <th class="text-nowrap text-center">Stok</th>
                                <th class="actions"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td data-order="{{ $product->price }}" class="text-right text-nowrap">{{ rupiah($product->price) }}</td>
                                <td class="text-center text-nowrap">{{ $product->total_stock }}</td>
                                <td class="text-right">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info"><i
                                            class="far fa-eye"></i></a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning"><i
                                            class="far fa-edit"></i></a>
                                    <?php /* <form class="delete-form d-inline-block" action="{{ route('products.destroy', $product->id) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form> */ ?>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    Tidak ada data.
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Tambah Barang</div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="code">Kode Barang</label>
                            <input type="text" name="code" id="code" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Barang</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="price" id="price" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function($) {
        $('.delete-form').submit(function(event) {
            if( !confirm('Hapus data ini?') ) 
                event.preventDefault();
        })
    })
</script>
@endsection