@extends('layouts.app')

@section('content')


<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kontak</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-phone"></i> Kontak</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contact.store') }}" method="POST">
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
                            <label>Nomor Telepon</label>
                            <input type="tel" name="phone"  placeholder="Masukkan nomor" class="form-control @error('telp') is-invalid @enderror">
                            @error('telp')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
        </div>

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-phone"></i> Kontak</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Nomor Telepon</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td class="text-center">
                                    {{-- <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $contact->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button> --}}
                                    <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
    </section>
</div>



@stop