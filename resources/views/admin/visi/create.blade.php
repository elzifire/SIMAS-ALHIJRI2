<!-- resources/views/admin/visi/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>VISI DAN MISI</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-bell"></i> VISI DAN MISI</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.visi.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="visi" class="font-weight-bold">VISI</label>
                                <textarea name="visi" id="visi" class="form-control" rows="5"></textarea>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="misi">MISI</label>
                                <textarea name="misi" id="misi"  rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">SIMPAN</button>
                            </div>
                        </form>
                    </div>
                </div>
        </section>
    </div>
    <script src="https://cdn.tiny.cloud/1/31fk3dv7kvw3biknorel2anuvrzy0iivkk4x02kgiek0ygc1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
@endsection
