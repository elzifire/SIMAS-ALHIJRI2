```html
@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kampanye</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-megaphone"></i> Kampanye</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.campaign.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('campaigns.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.campaign.create') }}" class="btn btn-primary" style="padding-top: 10px;">
                                            <i class="fa fa-plus-circle"></i> TAMBAH
                                        </a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q" placeholder="Cari berdasarkan judul kampanye">
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
                                    <th scope="col">JUDUL</th>
                                    <th scope="col">KATEGORI</th>
                                    <th scope="col">TARGET DANA</th>
                                    <th scope="col">DANA TERKUMPUL</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col" style="width: 15%; text-align: center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($campaigns as $no => $campaign)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no + ($campaigns->currentPage()-1) * $campaigns->perPage() }}</th>
                                        <td>{{ $campaign->title }}</td>
                                        <td>{{ $campaign->category ? $campaign->category->name : '-' }}</td>
                                        <td>{{ number_format($campaign->goal_amount, 0, ',', '.') }}</td>
                                        <td>{{ number_format($campaign->total_collected, 0, ',', '.') }}</td>
                                        <td>{{ $campaign->status }}</td>
                                        <td class="text-center">
                                            @can('campaigns.edit')
                                                <a href="{{ route('admin.campaign.edit', $campaign->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            @can('campaigns.delete')
                                                <form action="{{ route('admin.campaign.destroy', $campaign->id) }}" method="POST" style="display: inline;">
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
                            {{ $campaigns->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
```