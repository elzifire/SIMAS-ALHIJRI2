@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Uang Kas</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-arrow-up"></i> KAS MASUK</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.cash.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('cash.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.cash.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan judul agenda">
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
                                <th scope="col">KEPERLUAN</th>
                                <th scope="col">NOMINAL</th>
                                <th scope="col">TANGGAL</th>
                                <th scope="col">TOTAL</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalCashFlow = 0;
                                @endphp
                                @foreach ($cashs as $no => $cash)
                                <tr>
                                    {{-- <th scope="row" style="text-align: center">{{ ++$no + ($cashs->currentPage()-1) * $cashs->perPage() }}</th> --}}
                                    
                                    <th scope="row" style="text-align: center">{{ $no++ }}</th>
                                    <td>{{ $cash->title }}</td>
                                    <td>{{ $cash->cash_flow }}</td>
                                    <td>{{ $cash->date }}</td>
                                    <td>@php
                                         $totalCashFlow += $cash->cash_flow; // Akumulasi totalCashFlow
                    echo $totalCashFlow;
                                    @endphp</td>
                                    <td class="text-center">
                                        @can('cash.edit')
                                            <a href="{{ route('admin.cash.edit', $cash->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan
                            
                                        @can('cash.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger"  id="{{ $cash->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                        {{-- <div style="text-align: center">
                            {{$cashs->links("vendor.pagination.bootstrap-4")}}
                        </div> --}}
                        
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
                        url: "/admin/cash/"+id,
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