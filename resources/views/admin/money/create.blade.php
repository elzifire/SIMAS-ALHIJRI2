@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah KAS Masuk</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-bell"></i> TAMBAH KAS MASUK</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.money.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="jumlah">Jumlah (Rp):</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" min="0"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis KAS Masuk:</label>
                                <select name="jenis" id="jenis" class="form-control" required>
                                    <option value="masuk">Masuk</option>
                                    <option value="keluar">Keluar</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Optional JavaScript for your form, like input formatting or validations
const jumlahInput = document.getElementById('');
jumlahInput.addEventListener('input', function() {
    this.value = formatRupiah(this.value, 12);
});

function formatRupiah(angka, decimalPlaces) {
    const number = angka.replace(/[^,\d]/g, '');
    const split = number.split(',');
    let ribuan = split[0].length % 3;
    if (ribuan > 0) {
        ribuan = 3 - ribuan;
    }
    let rupiah = split[0].substr(0, ribuan);
    let ribuanTemp = split[0].substr(ribuan);
    let hasil = '';
    if (ribuanTemp !== '') {
        for (let i = 0; i < ribuanTemp.length; i += 3) {
            hasil += ribuanTemp.substr(i, 3) + '.';
        }
    }
    hasil = hasil.slice(0, -1);
    return hasil ? rupiah + '.' + hasil : rupiah;
}

    </script>
@stop
