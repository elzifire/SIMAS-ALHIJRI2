@extends('layouts.app')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Data Mualaf</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-user"></i> Detail Mualaf</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $mualaf->name }}</td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $mualaf->nik }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $mualaf->gender }}</td>
                            </tr>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td>{{ $mualaf->tmptlahir }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ \Carbon\Carbon::parse($mualaf->birthdate)->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>{{ $mualaf->pekerjaan }}</td>
                            </tr>
                            <tr>
                                <th>Agama Sebelumnya</th>
                                <td>{{ ucfirst($mualaf->agama) }}</td>
                            </tr>
                            <tr>
                                <th>Kebangsaan</th>
                                <td>{{ $mualaf->kebangsaan }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $mualaf->email }}</td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <td>{{ $mualaf->phone }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Tinggal</th>
                                <td>{{ $mualaf->address }}</td>
                            </tr>
                            <tr>
                                <th>Alamat KTP</th>
                                <td>{{ $mualaf->alamatktp }}</td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td>
                                    @if ($mualaf->photo)
                                        <img src="{{ asset('storage/' . $mualaf->photo) }}" alt="Foto Mualaf" width="150" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Session ID</th>
                                <td>{{ $mualaf->session_id }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pendaftaran</th>
                                <td>{{ $mualaf->created_at->format('d M Y - H:i') }}</td>
                            </tr>
                        </table>

                        <a href="{{ route('admin.mualaf.index') }}" class="btn btn-secondary mt-3">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
