@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Berita</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-book-open"></i> Tambah Berita</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>KATEGORI</label>
                                <select class="form-control select-category @error('category_id') is-invalid @enderror" name="category_id">
                                    <option value="">-- PILIH KATEGORI --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>JUDUL BERITA</label>
                                <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan Judul Berita" class="form-control @error('title') is-invalid @enderror">

                                @error('title')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            
                            <div class="form-group">
                                <label>KONTEN</label>
                                <textarea class="form-control content @error('content') is-invalid @enderror" name="content" placeholder="Masukkan Konten / Isi Berita" rows="10">{!! old('content') !!}</textarea>
                                @error('content')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>GAMBAR</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- date --}}
                            <div class="form-group">
                                <label>TANGGAL</label>
                                <input type="date" name="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror">

                                @error('date')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="font-weight-bold">TAGS</label>
                                <select class="form-control" name="tags[]" multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i> SIMPAN</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                            {{-- buatkan modal untuk memilih baca juga artikel terkait --}}
                            {{-- <div id="relatedPostsModal" class="modal" style="display: none; position: fixed; top: 20%; left: 50%; transform: translate(-50%, -20%); background: white; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000;">
                                <div class="modal-content">
                                    <h2b>Pilih Artikel Terkait</h2b>
                                    <div class="related-posts">
                                        @foreach ($Posts as $post)
                                        <li>
                                            <button class="btn-insert-related" data-link="{{ route('post.show', $post->id) }}" data-title="{{ $post->title }}">
                                                {{ $post->title }}
                                            </button>
                                        </li>
                                        @endforeach
                                    </div>
                                </div>
                                <button onclick="document.getElementById('relatedPostsModal').style.display='none'">Tutup</button>
                            </div>
                             --}}
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    

  
<script src="https://cdn.tiny.cloud/1/31fk3dv7kvw3biknorel2anuvrzy0iivkk4x02kgiek0ygc1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.0/tinymce.min.js" integrity="sha512-/4EpSbZW47rO/cUIb0AMRs/xWwE8pyOLf8eiDWQ6sQash5RP1Cl8Zi2aqa4QEufjeqnzTK8CLZWX7J5ZjLcc1Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script>
    tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | bacaJugaButton',
    icons: 'material',

    // Tambahkan tombol custom
//     setup: function (editor) {
//         editor.ui.registry.addButton('bacaJugaButton', {
//             text: 'Baca Juga',
//             onAction: function () {
//                 // Buka modal untuk memilih artikel
//                 const modal = document.getElementById('relatedPostsModal');
//                 modal.style.display = 'block';
//             }
//         });
//     }
    
//   });
//   document.querySelectorAll('.btn-insert-related').forEach(button => {
//         button.addEventListener('click', function () {
//             const link = this.getAttribute('data-link');
//             const title = this.getAttribute('data-title');

//             // Sisipkan ke dalam konten TinyMCE
//             tinymce.activeEditor.execCommand('mceInsertContent', false, `<p><strong>Baca Juga:</strong> <a href="${link}" target="_blank">${title}</a></p>`);

//             // Tutup modal
//             document.getElementById('relatedPostsModal').style.display = 'none';
//         });
//     });
</script>
@stop