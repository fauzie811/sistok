@extends('layouts.app')

@section('title')
Data Pengeluaran Lain - {{ date('Y-m-d') }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pengeluaran Lain</div>
                <div class="card-body">
                    @if (sizeof($expenses) > 0)
                    <table class="datatable table mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th class="text-nowrap text-right">Nominal</th>
                                <th class="actions"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td data-order="{{ $expense->date }}" class="text-nowrap">{{ $expense->date->format('d M Y') }}</td>
                                <td>{{ $expense->description }}</td>
                                <td data-order="{{ $expense->amount }}" class="text-right text-nowrap">{{ rupiah($expense->amount) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning"><i
                                            class="far fa-edit"></i></a>
                                    <form class="delete-form d-inline-block" action="{{ route('expenses.destroy', $expense->id) }}"
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
                <div class="card-header">Tambah Pengeluaran Lain</div>
                <div class="card-body">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        {{ csrf_field() }}
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
                            <label for="amount">Nominal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control" name="amount" id="amount" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <input type="text" name="description" id="description" class="form-control" required>
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