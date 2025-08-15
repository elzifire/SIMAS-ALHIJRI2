@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Kampanye</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-megaphone"></i> Edit Kampanye</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.campaign.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Judul Kampanye</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $campaign->title) }}" placeholder="Masukkan judul kampanye">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach (\App\Models\CategoriesCampaign::all() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $campaign->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="goal_amount">Target Dana (Rp)</label>
                            <input type="text" name="goal_amount" id="goal_amount" class="form-control rupiah @error('goal_amount') is-invalid @enderror" value="{{ old('goal_amount', number_format($campaign->goal_amount, 0, ',', '.')) }}" placeholder="Masukkan target dana">
                            @error('goal_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Masukkan deskripsi kampanye">{{ old('description', $campaign->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="expired">Tanggal Kadaluarsa</label>
                            <input type="date" name="expired" id="expired" class="form-control @error('expired') is-invalid @enderror" value="{{ old('expired', $campaign->expired) }}">
                            @error('expired')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control select2 @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $campaign->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $campaign->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_info">Informasi Bank</label>
                            <textarea name="bank_info" id="bank_info" class="form-control @error('bank_info') is-invalid @enderror" rows="3" placeholder="Masukkan informasi bank">{{ old('bank_info', $campaign->bank_info) }}</textarea>
                            @error('bank_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Kampanye</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                            @if ($campaign->image)
                                <small class="form-text text-muted">Gambar saat ini: <a href="{{ Storage::url($campaign->image) }}" target="_blank">Lihat</a></small>
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            <a href="{{ route('admin.campaign.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@push('scripts')
<script>
(function () {
    const formatRupiah = (val) => {
        if (!val) return '';
        // Sisain angka & koma (kalau mau 2 desimal nanti tinggal dipakai)
        let raw = val.toString().replace(/[^0-9,]/g, '');
        let parts = raw.split(',');
        let intPart = parts[0].replace(/^0+(?=\d)/, ''); // buang leading zero

        let sisa = intPart.length % 3;
        let rupiah = intPart.substr(0, sisa);
        let ribuan = intPart.substr(sisa).match(/\d{3}/g);
        if (ribuan) rupiah += (sisa ? '.' : '') + ribuan.join('.');

        // kalau mau dukung 2 desimal pakai koma, aktifin baris ini:
        // if (parts[1]) rupiah += ',' + parts[1].slice(0, 2);

        return rupiah ? 'Rp ' + rupiah : '';
    };

    const cleanRupiah = (val) => (val || '').replace(/[^0-9]/g, '');

    const inputs = document.querySelectorAll('.rupiah');

    inputs.forEach((input) => {
        // format nilai awal (termasuk dari old() atau number_format)
        input.value = formatRupiah(input.value);

        input.addEventListener('input', function () {
            const start = this.selectionStart || 0;
            const before = this.value;

            // format
            this.value = formatRupiah(before);

            // coba pertahankan posisi caret biar nggak loncat
            const diff = this.value.length - before.length;
            const pos = Math.max(0, start + diff);
            this.setSelectionRange(pos, pos);
        });

        input.addEventListener('blur', function () {
            // kalau kosong, jangan tampilkan "Rp "
            if (!cleanRupiah(this.value)) this.value = '';
        });
    });

    // bersihin semua input .rupiah jadi angka doang pas submit
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', function () {
            form.querySelectorAll('.rupiah').forEach((input) => {
                input.value = cleanRupiah(input.value);
            });
        });
    });
})();
</script>
@endpush


@endsection
