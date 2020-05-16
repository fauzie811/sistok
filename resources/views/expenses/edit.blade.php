@extends('layouts.app')

@section('title')
Edit Pengeluaran Lain
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Pengeluaran Lain</div>
                <div class="card-body">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="date" id="date"
                                    value="{{ $expense->date->format('Y-m-d') }}" autocomplete="off" data-provide="datepicker" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Keterangan</label>
                            <div class="col-sm">
                                <input type="text" name="description" id="description" class="form-control" required
                                    value="{{ $expense->description }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Nominal</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="amount" id="amount" class="form-control" required
                                        value="{{ $expense->amount }}">
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