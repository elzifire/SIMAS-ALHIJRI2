@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kampanye</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-megaphone"></i> Tambah Kampanye</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.campaign.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Judul Kampanye</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul kampanye">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach (\App\Models\CategoriesCampaign::all() as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="goal_amount">Target Dana (Rp)</label>
                            <input type="text" name="goal_amount" id="goal_amount" class="form-control rupiah @error('goal_amount') is-invalid @enderror" value="{{ old('goal_amount') ? number_format(old('goal_amount'), 0, ',', '.') : '' }}" placeholder="Masukkan target dana">
                            @error('goal_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Masukkan deskripsi kampanye">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="expired">Tanggal Kadaluarsa</label>
                            <input type="date" name="expired" id="expired" class="form-control @error('expired') is-invalid @enderror" value="{{ old('expired') }}">
                            @error('expired')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_info">Informasi Bank</label>
                            <textarea name="bank_info" id="bank_info" class="form-control @error('bank_info') is-invalid @enderror" rows="3" placeholder="Masukkan informasi bank">{{ old('bank_info') }}</textarea>
                            @error('bank_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Kampanye</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
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

@stack('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|', 
                    'outdent', 'indent', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'numberedList', 'bulletedList', '|',
                    'undo', 'redo', '|',
                    'code', 'codeBlock', 'horizontalLine', 'specialCharacters'
                ],
                alignment: {
                    options: [ 'left', 'center', 'right', 'justify' ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>

<script>
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    function cleanRupiah(rupiah) {
        return rupiah.replace(/[^0-9]/g, '');
    }

    document.querySelectorAll('.rupiah').forEach(input => {
        input.addEventListener('input', function(e) {
            let cursorPos = this.selectionStart;
            let beforeLength = this.value.length;

            this.value = formatRupiah(this.value);

            let afterLength = this.value.length;
            this.selectionEnd = cursorPos + (afterLength - beforeLength);
        });

        input.addEventListener('change', function() {
            this.value = formatRupiah(this.value);
        });
    });

    // Bersihin format sebelum submit
    document.querySelector('form').addEventListener('submit', function() {
        document.querySelectorAll('.rupiah').forEach(input => {
            input.value = cleanRupiah(input.value);
        });
    });
</script>

@endsection
