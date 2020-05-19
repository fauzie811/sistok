@extends('layouts.app')

@section('title')
Data Barang Keluar - {{ date('Y-m-d') }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Barang Keluar</div>
                <div class="card-body">
                    @if (sizeof($transactions) > 0)
                    <table class="datatable table mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th class="text-nowrap text-right">Harga Jual</th>
                                <th class="text-nowrap text-center">Qty</th>
                                <th class="text-nowrap text-right">Total</th>
                                <th class="actions"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td data-order="{{ $transaction->date }}" class="text-nowrap">{{ $transaction->date->format('d M Y') }}</td>
                                <td>{{ $transaction->product->name }}</td>
                                <td data-order="{{ $transaction->price }}" class="text-right text-nowrap">{{ rupiah($transaction->price) }}</td>
                                <td class="text-center text-nowrap">{{ $transaction->quantity }}</td>
                                <td data-order="{{ $transaction->total }}" class="text-right text-nowrap">{{ rupiah($transaction->total) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-info"><i
                                            class="far fa-eye"></i></a>
                                    {{-- <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-sm btn-warning"><i
                                            class="far fa-edit"></i></a> --}}
                                    <form class="delete-form d-inline-block" action="{{ route('transactions.destroy', $transaction->id) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
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
                <div class="card-header">Tambah Barang Keluar</div>
                <div 
                    class="card-body"
                    x-data="{
                        price: 0,
                        qty: 1,
                        total: 0,
                    }"
                    x-init="
                        select = $($refs.product).select2({
                            ajax: {
                                url: '{{ route('products.ajax') }}',
                                dataType: 'json',
                                delay: 250,
                                minimumInputLength: 2,
                                cache: true,
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                price: item.price,
                                                text: item.name,
                                                id: item.id
                                            }
                                        })
                                    }
                                }
                            }
                        });
                        select.on('select2:select', e => {
                            price = e.params.data.price
                            total = price * qty
                        })
                    "
                >
                    <form action="{{ route('transactions.store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" value="out">
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="date" id="date"
                                    value="{{ date('Y-m-d') }}" autocomplete="off" data-provide="datepicker" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_id">Nama Barang</label>
                            <select x-ref="product" name="product_id" id="product_id" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label for="price">Harga Jual Satuan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    name="price" 
                                    id="price"
                                    x-model="price"
                                    @change="total = price * qty"
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Jumlah</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                name="quantity" 
                                id="quantity"
                                x-model="qty"
                                @change="total = price * qty"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="total">Total Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    name="total" 
                                    id="total"
                                    x-model="total"
                                    required
                                >
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