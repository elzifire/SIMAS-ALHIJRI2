```html
@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Donatur</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-gift"></i> Donatur</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.donation.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('donations.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.donation.create') }}" class="btn btn-primary" style="padding-top: 10px;">
                                            <i class="fa fa-plus-circle"></i> TAMBAH
                                        </a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan nama donatur">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center; width: 6%">NO.</th>
                                    <th scope="col">NAMA</th>
                                    <th scope="col">KAMPANYE</th>
                                    <th scope="col">JUMLAH (Rp)</th>
                                    <th scope="col">TIPE DONASI</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col" style="width: 15%; text-align: center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations as $no => $donation)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no + ($donations->currentPage()-1) * $donations->perPage() }}</th>
                                        <td>{{ $donation->name }}</td>
                                        <td>{{ $donation->campaign ? $donation->campaign->title : '-' }}</td>
                                        <td>{{ number_format($donation->amount, 0, ',', '.') }}</td>
                                        <td>{{ $donation->donation_type ?? '-' }}</td>
                                        <td>{{ $donation->status ? $donation->status->name : '-' }}</td>
                                        <td class="text-center">
                                            @can('donations.edit')
                                                <a href="{{ route('admin.donation.edit', $donation->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('donations.delete')
                                                <form action="{{ route('admin.donation.destroy', $donation->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{ $donations->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
```