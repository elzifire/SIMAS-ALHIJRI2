@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Nama Imam</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-bell"></i> Edit Nama Imam</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.leader.update', $leader->id) }}" method="POST" enctype="multipart/form-data">  
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>NAMA IMAM</label>
                                <input type="text" name="name" value="{{ old('name', $leader->name) }}" placeholder="Masukkan Nama Imam" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>NOMOR TELEPON IMAM</label>
                                <input type="text" name="telp" value="{{ old('telp', $leader->telp) }}" placeholder="Masukkan Nomor Telepon Imam" class="form-control @error('telp') is-invalid @enderror">
                                @error('telp')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>FOTO IMAM</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if ($leader->image)
                                    <img src="{{ asset('storage/leader/' . $leader->image) }}" alt="Leader Image" class="img-thumbnail mt-2" style="max-width: 200px;">
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
