@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah KAS Masuk</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-bell"></i> TAMBAH KAS MASUK</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.money.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="jumlah">Jumlah (Rp):</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis KAS Masuk:</label>
                                <select name="jenis" id="jenis" class="form-control" required>
                                    <option value="masuk">Masuk</option>
                                    <option value="keluar">Keluar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
