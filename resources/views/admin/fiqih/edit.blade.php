@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Fiqih</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('admin.fiqih.index') }}">Manajemen Fiqih</a></div>
                <div class="breadcrumb-item active">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.fiqih.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id" value="{{ $item->id }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="arabic" class="form-label">Arabic</label>
                            <textarea class="form-control" id="arabic" name="arabic" rows="5" required>{!! $item->arabic !!}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="indonesia" class="form-label">Indonesia</label>
                            <textarea class="form-control" id="indonesia" name="indonesia" rows="5" required>{!! $item->indonesia !!}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.fiqih.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- TinyMCE terbaru v6 -->
<script src="https://cdn.tiny.cloud/1/31fk3dv7kvw3biknorel2anuvrzy0iivkk4x02kgiek0ygc1/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    menubar: false,
    relative_urls: false
});
</script>
@endsection