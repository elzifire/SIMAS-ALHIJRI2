@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Donasi</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-gift"></i> Tambah Donasi</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.donation.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Donatur</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Masukkan nama donatur">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Nomor Telepon</label>
                                <input type="text" name="phone_number" id="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    value="{{ old('phone_number') }}" placeholder="Masukkan nomor telepon">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="campaign_id">Kampanye</label>
                                <select name="campaign_id" id="campaign_id"
                                    class="form-control select2 @error('campaign_id') is-invalid @enderror">
                                    <option value="">Pilih Kampanye</option>
                                    @foreach (\App\Models\Campaign::all() as $campaign)
                                        <option value="{{ $campaign->id }}"
                                            {{ old('campaign_id') == $campaign->id ? 'selected' : '' }}>
                                            {{ $campaign->title }}</option>
                                    @endforeach
                                </select>
                                @error('campaign_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status_id">Status</label>
                                <select name="status_id" id="status_id"
                                    class="form-control select2 @error('status_id') is-invalid @enderror">
                                    <option value="">Pilih Status</option>
                                    @foreach (\App\Models\Status::whereIn('name', ['approved', 'rejected'])->get() as $status)
                                        <option value="{{ $status->id }}"
                                            {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ ucfirst($status->name) }}</option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="amount">Jumlah Donasi (Rp)</label>
                                <input type="text" name="amount" id="amount"
                                    class="form-control rupiah @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" placeholder="Masukkan jumlah donasi">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="proof_image">Bukti Transfer</label>
                                <input type="file" name="proof_image" id="proof_image"
                                    class="form-control @error('proof_image') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg">
                                @error('proof_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                <a href="{{ route('admin.donation.index') }}" class="btn btn-secondary"><i
                                        class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @stack('scripts')
    <script>
        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        }

        function cleanRupiah(rupiah) {
            return rupiah.replace(/[^0-9]/g, '');
        }

        document.querySelectorAll('.rupiah').forEach(input => {
            // Format saat load jika sudah ada nilai
            if (input.value) {
                input.value = formatRupiah(input.value);
            }

            // Format saat user mengetik
            input.addEventListener('input', function() {
                let pos = this.selectionStart;
                let beforeLength = this.value.length;
                this.value = formatRupiah(this.value);
                let afterLength = this.value.length;
                this.selectionEnd = pos + (afterLength - beforeLength);
            });

            // Format lagi kalau blur
            input.addEventListener('blur', function() {
                this.value = formatRupiah(this.value);
            });
        });

        // Bersihkan sebelum submit form
        document.querySelector('form').addEventListener('submit', function() {
            document.querySelectorAll('.rupiah').forEach(input => {
                input.value = cleanRupiah(input.value);
            });
        });
    </script>
@endsection
