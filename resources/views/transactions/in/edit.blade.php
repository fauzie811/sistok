@extends('layouts.app')

@section('title')
Edit Barang Masuk - #{{ $transaction->id }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Barang Masuk</div>
                <div 
                    class="card-body"
                    x-data="{
                        price: {{ $transaction->price }},
                        qty: {{ $transaction->quantity }},
                        total: {{ $transaction->total }},
                        lastChanged: 'price'
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
                            lastChanged = 'price'
                            total = price * qty
                        })
                    "
                >
                    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" name="date" id="date" class="form-control" required
                                        value="{{ $transaction->date }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_id" class="col-md-4 col-form-label text-md-right">Nama Barang</label>
                            <div class="col-sm">
                                <select x-ref="product" name="product_id" id="product_id" class="form-control" required>
                                    <option value="{{ $transaction->product_id }}" selected>{{ $transaction->product->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Harga Beli Satuan</label>
                            <div class="col-md-4">
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
                                        @focus="lastChanged='price'"
                                        @change="
                                            if (lastChanged == 'price') {
                                                total = price * qty
                                            }
                                        "
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Jumlah</label>
                            <div class="col-md-2">
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    name="quantity" 
                                    id="quantity"
                                    x-model="qty"
                                    @change="
                                        if (lastChanged == 'price') {
                                            total = price * qty
                                        } else {
                                            price = total / qty
                                        }
                                    "
                                    required
                                >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Total Harga</label>
                            <div class="col-md-4">
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
                                        @focus="lastChanged='total'"
                                        @change="
                                            if (lastChanged == 'total') {
                                                price = total / qty
                                            }
                                        "
                                        required
                                    >
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