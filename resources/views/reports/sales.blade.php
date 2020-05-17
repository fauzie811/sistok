@extends('layouts.app')

@section('title')
Laporan Penjualan - {{ $date_start }} - {{ $date_end }}
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Pencarian</div>
        <div class="card-body">
            <form action="{{ route('reports.sales') }}" method="GET">
                <div class="form-row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="date_start">Tanggal Awal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="date_start" id="date_start"
                                    value="{{ isset($date_start) ? $date_start : '' }}" autocomplete="off" data-provide="datepicker" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="date_end">Tanggal Akhir</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="date_end" id="date_end"
                                    value="{{ isset($date_end) ? $date_end : '' }}" autocomplete="off" data-provide="datepicker" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm">
                        <button type="submit" class="btn btn-block btn-primary">Cari</button>
                    </div>
                    <div class="col-sm">
                        <a href="{{ route('reports.sales') }}" class="btn btn-block btn-light">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Laporan Penjualan</div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th class="text-right">Total Harga Jual</th>
                        <th class="text-right">Harga Beli Satuan</th>
                        <th class="text-right">Harga Jual Satuan</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Total Laba</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_profit = 0; ?>
                    @foreach ($items as $item)
                    <?php
                    $total_profit += $item->total - ($item->stock->purchase_price * $item->quantity)
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td data-order="{{ $item->transaction->date }}" class="text-nowrap">{{ $item->transaction->date->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('products.show', $item->stock->product_id) }}">{{ $item->stock->product->name }}</a>
                        </td>
                        <td data-order="{{ $item->total }}" class="text-right text-nowrap">
                            {{ rupiah($item->total) }}
                        </td>
                        <td data-order="{{ $item->stock->purchase_price }}" class="text-right text-nowrap">
                            {{ rupiah($item->stock->purchase_price) }}
                        </td>
                        <td data-order="{{ $item->total / $item->quantity }}" class="text-right text-nowrap">
                            {{ rupiah($item->total / $item->quantity) }}
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td data-order="{{ $item->total - ($item->stock->purchase_price * $item->quantity) }}" class="text-right text-nowrap">
                            {{ rupiah($item->total - ($item->stock->purchase_price * $item->quantity)) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            <strong>{{ rupiah($total_profit) }}</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection