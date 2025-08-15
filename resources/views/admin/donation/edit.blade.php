@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Donasi</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-gift"></i> Edit Donasi</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.donation.update', $donation->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Donatur</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $donation->name) }}" placeholder="Masukkan nama donatur">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Nomor Telepon</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $donation->phone_number) }}" placeholder="Masukkan nomor telepon">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="donation_type">Tipe Donasi</label>
                            <input type="text" name="donation_type" id="donation_type" class="form-control @error('donation_type') is-invalid @enderror" value="{{ old('donation_type', $donation->donation_type) }}" placeholder="Masukkan tipe donasi" hidden>
                            @error('donation_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="campaign_id">Kampanye</label>
                            <select name="campaign_id" id="campaign_id" class="form-control select2 @error('campaign_id') is-invalid @enderror">
                                <option value="">Pilih Kampanye</option>
                                @foreach (\App\Models\Campaign::all() as $campaign)
                                    <option value="{{ $campaign->id }}" {{ old('campaign_id', $donation->campaign_id) == $campaign->id ? 'selected' : '' }}>{{ $campaign->title }}</option>
                                @endforeach
                            </select>
                            @error('campaign_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status pakai radio button --}}
                        <div class="form-group">
                            <label>Status</label>
                            <div>
                                @php
                                    $rejectedId = \App\Models\Status::where('name', 'rejected')->value('id') ?? 0;
                                @endphp
                                @foreach (\App\Models\Status::all() as $status)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input status-radio" type="radio" name="status_id" id="status_{{ $status->id }}" value="{{ $status->id }}" 
                                            {{ old('status_id', $donation->status_id) == $status->id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_{{ $status->id }}">
                                            {{ ucfirst($status->name) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('status_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Alasan penolakan --}}
                        <div class="form-group" id="rejected_reason_group" style="display: none;">
                            <label for="rejected_reason">Alasan Penolakan</label>
                            <textarea name="rejected_reason" id="rejected_reason" class="form-control @error('rejected_reason') is-invalid @enderror" rows="3" placeholder="Masukkan alasan penolakan">{{ old('rejected_reason', $donation->rejected_reason) }}</textarea>
                            @error('rejected_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="amount">Nominal Donasi (Rp)</label>
                            <input type="text" name="amount" id="amount" class="form-control rupiah @error('amount') is-invalid @enderror" value="{{ old('amount', number_format($donation->amount, 0, ',', '.')) }}" placeholder="Masukkan jumlah donasi" >
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="proof_image">Bukti Transfer</label>
                            <input type="file" name="proof_image" id="proof_image" class="form-control @error('proof_image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                            @if ($donation->proof_image)
                                <small class="form-text text-muted">Gambar saat ini: <a href="{{ Storage::url($donation->proof_image) }}" target="_blank">Lihat</a></small>
                            @endif
                            @error('proof_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            <a href="{{ route('admin.donation.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function formatRupiah(angka) {
        if (!angka) return '';
        let number_string = angka.replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        let separator = '';
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    function cleanRupiah(rupiah) {
        return (rupiah || '').toString().replace(/[^0-9]/g, '');
    }

    // Format input rupiah
    document.querySelectorAll('.rupiah').forEach(input => {
        input.addEventListener('focus', function() {
            this.value = cleanRupiah(this.value);
        });
        input.addEventListener('input', function() {
            this.value = formatRupiah(this.value);
        });
        input.addEventListener('blur', function() {
            this.value = formatRupiah(this.value);
        });
    });

    // Bersihkan sebelum submit
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelectorAll('.rupiah').forEach(input => {
            input.value = cleanRupiah(input.value);
        });
    });

    // Toggle alasan penolakan pakai radio
    document.addEventListener('DOMContentLoaded', function() {
        const rejectedReasonGroup = document.getElementById('rejected_reason_group');
        const rejectedStatusId = parseInt("{{ $rejectedId }}") || 0;

        function toggleRejectedReason() {
            const selected = document.querySelector('input[name="status_id"]:checked');
            if (selected && parseInt(selected.value) === rejectedStatusId) {
                rejectedReasonGroup.style.display = 'block';
            } else {
                rejectedReasonGroup.style.display = 'none';
            }
        }

        // Event listener semua radio
        document.querySelectorAll('.status-radio').forEach(radio => {
            radio.addEventListener('change', toggleRejectedReason);
        });

        // Jalanin pas load awal
        toggleRejectedReason();
    });
</script>
@endsection
