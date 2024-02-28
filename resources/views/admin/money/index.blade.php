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
                    <h4><i class="fa-solid fa-money-check"></i>Keuangan</h4>
                </div>

                <div class="card-body">
                    
                    @can('moneys.create')
                    <div class="input-group-prepend">
                        <a href="{{ route('admin.money.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH KAS MASUK</a>
                    </div>
                    @endcan
                
                    <div class="table-responsive">
                        @if (session('success'))
  <div class="alert alert-success" role="alert">
      {{ session('success') }}
  </div>
@endif

<div class="row">
  <div class="col-md-4">
    <form action="{{ route('admin.money.index') }}" method="GET">
      <div class="form-group">
        <label for="jenis">Jenis</label>
        <select name="jenis" class="form-control">
          <option value="">Semua</option>
          <option value="masuk">Masuk</option>
          <option value="keluar">Keluar</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary mb-4">Filter</button>
    </form>
  </div>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" style="text-align: center;width: 6%">NO.</th>
      <th scope="col">KETERANGAN</th>
      <th scope="col">JENIS</th>
      <th scope="col">TANGGAL</th>
      <th scope="col">JUMLAH</th>
      <th scope="col" style="width: 15%;text-align: center">AKSI</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($moneys as $no => $money)
      <tr>
        <th scope="row" style="text-align: center">{{ ($moneys->currentPage() - 1) * $moneys->perPage() + $no + 1 }}</th>
        <td>Rp. {{ $money->keterangan }}</td>
        <td>{{ $money->jenis }}</td>
        <td>{{ $money->tanggal }}</td>
        <td>Rp. {{ number_format($money->jumlah, 0, ',', '.') }}</td>
        <td class="text-center">
          @can('moneys.edit')
          <a href="{{ route('admin.money.edit', $money->id) }}" class="btn btn-sm btn-primary">
              <i class="fa fa-pencil-alt"></i>
            </a>
          @endcan
          @can('moneys.delete')
            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $money->id }}">
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
          <th><span>Rp. {{ number_format($totalMasuk, 0, ',', '.') }}</span></th> </tr>
      <tr>
          <th colspan="5" class="text-right p-3">UANG KELUAR :</th>
          <th><span>Rp. {{ number_format($totalKeluar, 0, ',', '.') }}</span></th>
      </tr>
      <tr>
        <th colspan="5" class="text-right p-3">SALDO</th>
        <th><span>Rp.{{ number_format(App\Models\Money::latest()->first()->saldo ?? '0', 0, ',', '.') }}</span></th>
    </tr>
    
  </tfoot>
  
</table>
{{ $moneys->links("vendor.pagination.bootstrap-5") }}


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
                    url: "/admin/money/"+id,
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
