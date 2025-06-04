@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Data Mualaf</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('admin.mualaf.index') }}">Data Mualaf</a></div>
                <div class="breadcrumb-item active">Detail: {{ $mualaf->name ?? $mualaf->id }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-user-check"></i> Detail Pendaftaran: {{ $mualaf->name ?? '-' }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.mualaf.edit', $mualaf->id) }}" class="btn btn-warning btn-icon icon-left">
                            <i class="fas fa-edit"></i> Edit Data
                        </a>
                        <a href="{{ route('admin.mualaf.index') }}" class="btn btn-light btn-icon icon-left">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        {{-- 
                        <a href="#" class="btn btn-success btn-icon icon-left">
                            <i class="fas fa-download"></i> Download Surat
                        </a> 
                        --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-primary">Data Calon Mualaf</h5>
                            <table class="table table-sm table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 25%;">Nama Lengkap</th>
                                        <td>{{ $mualaf->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIK</th>
                                        <td>{{ $mualaf->nik ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>{{ $mualaf->gender ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat, Tanggal Lahir</th>
                                        <td>{{ $mualaf->tmptlahir ?? '-' }}{{ ($mualaf->tmptlahir && $mualaf->birthdate) ? ', ' : '' }}{{ $mualaf->birthdate ? \Carbon\Carbon::parse($mualaf->birthdate)->isoFormat('D MMMM YYYY') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pekerjaan</th>
                                        <td>{{ $mualaf->pekerjaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Agama Sebelumnya</th>
                                        <td>{{ ucfirst($mualaf->agama ?? '-') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kebangsaan</th>
                                        <td>{{ $mualaf->kebangsaan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $mualaf->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>{{ $mualaf->phone ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Sekarang</th>
                                        <td>{{ $mualaf->address ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat Sesuai KTP</th>
                                        <td>{{ $mualaf->alamatktp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Foto</th>
                                        <td>
                                            @if($mualaf->photo)
                                                <a href="{{ asset('storage/' . $mualaf->photo) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $mualaf->photo) }}" alt="Foto Mualaf" style="max-width: 150px; max-height: 150px; border-radius: 5px; border: 1px solid #ddd;">
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak ada foto</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Session ID Pendaftaran</th>
                                        <td>{{ $mualaf->session_id ?? '-' }}</td>
                                    </tr>
                                     <tr>
                                        <th>Tanggal Pendaftaran</th>
                                        <td>{{ $mualaf->created_at ? $mualaf->created_at->isoFormat('dddd, D MMMM YYYY - HH:mm') : '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Saksi Pihak Mualaf (Saksi 1)</h5>
                            @if($mualaf->saksi && $mualaf->saksi->saksi_name)
                                <table class="table table-sm table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 35%;">Nama</th>
                                            <td>{{ $mualaf->saksi->saksi_name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>{{ $mualaf->saksi->saksi_nik ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $mualaf->saksi->gender_saksi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $mualaf->saksi->pekerjaan_saksi ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $mualaf->saksi->alamatsaksi ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">Data Saksi 1 tidak ditemukan atau belum diisi.</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-primary">Saksi Pihak Masjid (Saksi 2)</h5>
                            @if($mualaf->saksi && $mualaf->saksi->saksi_name2)
                                <table class="table table-sm table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 35%;">Nama</th>
                                            <td>{{ $mualaf->saksi->saksi_name2 ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td>{{ $mualaf->saksi->saksinik2 ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>{{ $mualaf->saksi->gender_saksi2 ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td>{{ $mualaf->saksi->pekerjaan_saksi2 ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $mualaf->saksi->alamatsaksi2 ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">Data Saksi 2 belum diisi oleh admin.</p>
                            @endif
                        </div>
                    </div>
                    
                    {{-- @if($mualaf->saksi)
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="text-primary">Session ID Saksi</h5>
                             <table class="table table-sm table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 25%;">Session ID Data Saksi</th>
                                        <td>{{ $mualaf->saksi->session_id ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif --}}

                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="text-primary">Pembimbing Ikrar</h5>
                            <table class="table table-sm table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 25%;">Nama Pembimbing Ikrar</th>
                                        <td>{{ $mualaf->nama_pembimbing_ikrar ?? 'Belum diisi oleh admin.' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
