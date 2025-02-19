@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Kategori Foto</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-folder"></i>Tambah Kategori Foto</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.category_photo.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label>NAMA KATEGORI FOTO</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Kategori" class="form-control @error('name') is-invalid @enderror">

                                @error('name')
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