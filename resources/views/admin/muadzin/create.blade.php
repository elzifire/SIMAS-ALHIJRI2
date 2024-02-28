@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Muadzin</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-person"></i>Tambah Muadzin</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.muadzin.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>NAMA IMAM</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Imam" class="form-control @error('name') is-invalid @enderror">

                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>NOMOR TELEPON</label>
                                <input type="text" name="telp"  placeholder="Masukkan Nomor WhatsApp"  value="{{ old('telp') }}" class="form-control @error('telp') is-invalid @enderror">
                                @error('telp')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>FOTO</label>
                                <input type="file" name="image"  placeholder="Masukkan Foto" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
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