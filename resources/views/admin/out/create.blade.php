@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>TAMBAH KAS KELUAR</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-money-check"></i> TAMBAH KAS KELUAR</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.out.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="tanggal">Keterangan</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" class="form-control"  name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah (Rp):</label>
                                <input type="number" class="form-control"  name="balance" min="0"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

   
@stop