@extends('layouts.app')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori Foto</h1>
        </div>

        <div class="section-body">

            @can('photos.create')
                <div class="card">
                    <div class="card-header">   
                        <h4><i class="fas fa-image"></i> Tambah Kategori Foto</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('admin.categories_photo.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Nama Kategori Foto" class="form-control @error('title') is-invalid @enderror">

                                @error('title')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="desc" value="{{ old('desc') }}" placeholder="Masukkan Deskripsi Kategori Foto" class="form-control @error('desc') is-invalid @enderror">
                                </textarea>
                                @error('desc')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- date --}}
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror">

                                @error('date')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- submit --}}
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-image"></i> Daftar Kategori Foto</h4>    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md">
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{!! $category->desc !!}</td>
                                    <td>{{ $category->date }}</td>
                                    <td>
                                       <img src="{{ $category->image }}" alt="" style="width: 150px">
                                    </td>
                                    <td>
                                        @can('photos.delete')
                                            <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $category->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </table>
                        <div style="text-align: center;">
                            {{ $categories->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>    
            </div>    
                
    </section>
</div>

<script src="https://cdn.tiny.cloud/1/31fk3dv7kvw3biknorel2anuvrzy0iivkk4x02kgiek0ygc1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    //ajax delete
    function Delete(id)
        {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {


                    //ajax delete
                    jQuery.ajax({
                        url: "/admin/categories_photo/"+id,
                        data:     {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function (response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }else{
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });

                } else {
                    return true;
                }
            })
        }


    tinymce.init({
        selector: 'textarea',
        height: 300,
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image | help',
    });
</script>
@stop