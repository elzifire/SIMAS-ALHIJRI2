@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Saksi</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h4>Form Tambah Saksi</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.witness.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nama Saksi</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama saksi">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                        <a href="{{ route('admin.witness.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection