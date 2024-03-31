@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Keuangan</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-enter-check"></i>Keuangan</h4>
                    </div>

                    <div class="card-body">

                        @can('enters.create')
                            <div class="input-group-prepend">
                                <a href="{{ route('admin.enter.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i
                                        class="fa fa-plus-circle"></i> TAMBAH KAS MASUK</a>
                            </div>
                        @endcan

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                        <th scope="col">KETERANGAN</th>
                                        <th scope="col">JENIS</th>
                                        <th scope="col">TANGGAL</th>
                                        <th scope="col">TOTAL</th>
                                        <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enters as $no => $enter)
                                        <tr>
                                            <th scope="row" style="text-align: center">{{ ($enters->currentPage() - 1) * $enters->perPage() + $no + 1 }}</th>
                                            <td>{{ $enter->name }}</td>
                                            <td>Uang Masuk</td>
                                            <td>{{ $enter->date }}</td>
                                            <td>{{ $enter->balance }}</td>
                                            <td class="text-center">
                                                @can('enters.edit')
                                                    <a href="{{ route('admin.enter.edit', $enter->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                @endcan
                                                @can('enters.delete')
                                                    <button onClick="Delete(this.id)" class="btn btn-sm btn-danger"
                                                        id="{{ $enter->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right p-3">UANG MASUK :</th>
                                        <th><span>Rp. {{ $moneyIn }}</span></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right p-3">UANG KELUAR :</th>
                                        <th><span>Rp.{{ $moneyOut }}</span></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right p-3">SALDO</th>
                                        <th><span>Rp. {{ $totalBalance }}</span>
                                        </th>
                                    </tr>

                                </tfoot>

                            </table>
                            {{ $enters->links('vendor.pagination.bootstrap-5') }}


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        //ajax delete
        function Delete(id) {
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
                        url: "/admin/enter/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
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
                            } else {
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
