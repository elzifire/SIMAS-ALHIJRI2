@extends('layouts.app')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Mualaf</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-users"></i> Data Mualaf</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.mualaf.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="q"
                                       placeholder="Cari berdasarkan nama mualaf">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> CARI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col">NAMA</th>
                                    <th scope="col">NIK</th>
                                    <th scope="col">GENDER</th>
                                    <th scope="col">TTL</th>
                                    <th scope="col">AGAMA SEBELUMNYA</th>
                                    <th scope="col" style="text-align: center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mualafs as $no => $mualaf)
                                    <tr>
                                        <th scope="row" style="text-align: center">
                                            {{ ++$no + ($mualafs->currentPage() - 1) * $mualafs->perPage() }}
                                        </th>
                                        <td>{{ $mualaf->name }}</td>
                                        <td>{{ $mualaf->nik }}</td>
                                        <td>{{ $mualaf->gender }}</td>
                                        <td>{{ $mualaf->tmptlahir }}, {{ \Carbon\Carbon::parse($mualaf->birthdate)->format('d-m-Y') }}</td>
                                        <td>{{ ucfirst($mualaf->agama) }}</td>
                                        <td style="text-align: center">
                                            <a href="{{ route('admin.mualaf.show', $mualaf->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data mualaf.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div style="text-align: center">
                            {{ $mualafs->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
