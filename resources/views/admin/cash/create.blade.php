@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Data Keuangan</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-coins"></i> Tambah Data Keuangan</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.cash.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>KEPERLUAN</label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Kepeluan" class="form-control @error('title') is-invalid @enderror">

                                @error('title')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>NOMINAL</label>
                                <input type="text" name="cash_flow" value="{{ old('cash_flow') }}" placeholder="Masukkan Nominal" class="form-control @error('cash_flow') is-invalid @enderror">

                                @error('cash_flow')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>TANGGAL</label>
                                <input type="date" name="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror">

                                @error('date')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    
@stop
