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
                    <form action="{{ route('admin.enter.update', $enter->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="jumlah">KETERANGAN</label>
                            <input type="text" class="form-control" id="jumlah" name="name"  value="{{ $enter->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">JUMLAH (Rp):</label>
                            <input type="number" class="form-control" id="jumlah" name="balance" min="0" value="{{ $enter->balance }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" class="form-control" id="tanggal" name="date" value="{{ $enter->date }}" required>
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