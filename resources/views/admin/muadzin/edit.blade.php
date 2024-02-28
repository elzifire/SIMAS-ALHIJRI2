@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Nama MUADZIN</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-person"></i>Edit Nama Muadzin</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.muadzin.update', $muadzin->id) }}" method="POST" enctype="multipart/form-data">  
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>NAMA MUADZIN</label>
                                <input type="text" name="name" value="{{ old('name', $muadzin->name) }}" placeholder="Masukkan Nama Muadzin" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>NOMOR TELEPON</label>
                                <input type="text" name="telp" value="{{ old('telp', $muadzin->telp) }}" placeholder="Masukkan Nomor Telepon Imam" class="form-control @error('telp') is-invalid @enderror">
                                @error('telp')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>FOTO MUADZIN</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if ($muadzin->image)
                                    <img src="{{ asset('storage/muadzin/' . $muadzin->image) }}" alt="Leader Image" class="img-thumbnail mt-2" style="max-width: 200px;">
                                @endif
                            </div>
                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> UPDATE</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
