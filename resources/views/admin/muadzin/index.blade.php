@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Muadzin Masjid</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-person"></i> Daftar Muadzin Masjid</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.muadzin.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('muadzins.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.muadzin.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan nama muadzin">
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
                                <th scope="col">NAMA MUADZIN</th>
                                <th scope="col">NOMOR TELEPON</th>
                                <th scope="col">FOTO</th>
                                <th scope="col" style="text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($muadzins as $no => $muadzin)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($muadzins->currentPage()-1) * $muadzins->perPage() }}</th>
                                    <td>{{ $muadzin->name }}</td>
                                    <td>{{ $muadzin->telp }}</td>
                                    <td><img src="{{ $muadzin->image }}" alt="" style="width: 125px"></td>       
                                    <td class="text-center">
                                        @can('muadzins.edit')
                                            <a href="{{ route('admin.muadzin.edit', $muadzin->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('muadzins.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $muadzin->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{$muadzins->links("vendor.pagination.bootstrap-4")}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

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
                        url: "/admin/muadzin/"+id,
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
</script>
@stop