@extends('layouts.app')

@section('content')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Layanan</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-phone"></i> Layanan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.service.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name"  placeholder="Masukkan nama" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>MASUKAN LINK WEBSITE</label>
                                <input type="url" name="url"  placeholder="Masukkan URL" class="form-control @error('url') is-invalid @enderror">
                                @error('url')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
    </div>

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-phone"></i> Layanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Link Website</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->url }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>


@stop