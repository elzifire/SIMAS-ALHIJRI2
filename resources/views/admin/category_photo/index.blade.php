@extends('layouts.app')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori Foto</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header flex-wrap">
                    <h4><i class="fas fa-image"></i> Foto</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.photo.index') }}" method="GET">
                        <div class="form-group mb-3">
                            <div class="input-group">
                                @can('photos.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route("admin.category_photo.create") }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan  kategori foto">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
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
                                <th scope="col">KATEGORI FOTO</th>
                                <th scope="col" style="width: 15%;text-align: center;">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $no => $photo)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($categories->currentPage()-1) * $categories->perPage() }}</th>
                                    <td>{{ $photo->name }}</td>
                                    <td class="text-center">
                                        {{-- @can('photos.edit')
                                            <a href="{{ route('admin.category_photo.edit', $photo->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan --}}
                                        
                                        @can('photos.delete')
                                            <form action="{{ route('admin.category_photo.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category photo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
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
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection