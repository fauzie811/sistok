@extends('layouts.app')

@section('title')
Laporan Keuangan - {{ $date_start }} - {{ $date_end }}
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Pencarian</div>
        <div class="card-body">
            <form action="{{ route('reports') }}" method="GET">
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
                        <a href="{{ route('reports') }}" class="btn btn-block btn-light">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Hasil Pencarian</div>
        <div class="card-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th class="text-right">Pemasukan</th>
                        <th class="text-right">Pengeluaran</th>
                        <th class="text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $last_balance = $old_balance; ?>
                    @foreach ($items as $item)
                    <?php
                    if ($item instanceof App\Expense) {
                        $last_balance -= $item->amount;
                    } elseif ($item->type == 'in') {
                        $last_balance += $item->total;
                    } else {
                        $last_balance -= $item->total;
                    }
                    ?>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td data-order="{{ $item->date }}" class="text-nowrap">{{ $item->date->format('d M Y') }}</td>
                        <td>
                            @if ($item instanceof App\Expense)
                            <strong>Pengeluaran Lain: </strong><br>{{ $item->description }}
                            @else
                            @if ($item->type == 'in')
                                <strong>Jual: </strong><br>{{ $item->product->name }}
                            @else
                                <strong>Beli: </strong><br>{{ $item->product->name }}
                            @endif
                            @endif
                        </td>
                        @if ($item instanceof App\Transaction && $item->type == 'in')
                        <td data-order="{{ $item->total }}" class="text-right text-nowrap">
                            {{ rupiah($item->total) }}
                        </td>
                        @else
                        <td></td>
                        @endif
                        @if ($item instanceof App\Transaction && $item->type == 'out')
                        <td data-order="{{ $item->total }}" class="text-right text-nowrap">
                            {{ rupiah($item->total) }}
                        </td>
                        @elseif ($item instanceof App\Expense)
                        <td data-order="{{ $item->amount }}" class="text-right text-nowrap">
                            {{ rupiah($item->amount) }}
                        </td>
                        @else
                        <td></td>
                        @endif
                        <td data-order="{{ $last_balance }}" class="text-right text-nowrap">
                            {{ rupiah($last_balance) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><strong>Saldo Akhir</strong></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            <strong>{{ rupiah($last_balance) }}</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection