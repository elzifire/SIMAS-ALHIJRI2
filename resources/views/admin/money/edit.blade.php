@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit KAS Masuk</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-edit"></i> EDIT KAS MASUK</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.money.update', $money->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="jumlah">KETERANGAN</label>
                            <input type="number" class="form-control" id="jumlah" name="keterangan" min="0" value="{{ $money->keterangan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">JUMLAH (Rp):</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" value="{{ $money->jumlah }}" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis KAS Masuk:</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="masuk" {{ $money->jenis == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="keluar" {{ $money->jenis == 'keluar' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $money->tanggal }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Optional JavaScript for your form, like input formatting or validations
</script>
@stop
