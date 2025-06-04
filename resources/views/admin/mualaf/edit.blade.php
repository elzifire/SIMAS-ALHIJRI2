@extends('layouts.app')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            {{-- Menggunakan nama pendaftar jika ada, jika tidak ID --}}
            <h1>Edit Data Pendaftaran Mualaf: {{ $pendaftaran->name ?? $pendaftaran->id }}</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Formulir Edit Data Pendaftaran</h4>
                </div>
                <div class="card-body">
                    {{-- Tambahkan enctype="multipart/form-data" jika Anda akan mengelola upload foto --}}
                    <form action="{{ route('admin.mualaf.update', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <fieldset class="mb-4">
                            <legend>Data Calon Mualaf</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $pendaftaran->name ?? '') }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nik">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $pendaftaran->nik ?? '') }}" required>
                                        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('gender', $pendaftaran->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('gender', $pendaftaran->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tmptlahir">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('tmptlahir') is-invalid @enderror" id="tmptlahir" name="tmptlahir" value="{{ old('tmptlahir', $pendaftaran->tmptlahir ?? '') }}" required>
                                        @error('tmptlahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birthdate">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate', $pendaftaran->birthdate ? \Carbon\Carbon::parse($pendaftaran->birthdate)->format('Y-m-d') : '') }}" required>
                                        @error('birthdate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $pendaftaran->pekerjaan ?? '') }}" required>
                                        @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="agama">Agama Sebelumnya <span class="text-danger">*</span></label>
                                        <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                                            <option value="">Pilih Agama</option>
                                            <option value="kristen" {{ old('agama', $pendaftaran->agama ?? '') == 'kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="hindu" {{ old('agama', $pendaftaran->agama ?? '') == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="budha" {{ old('agama', $pendaftaran->agama ?? '') == 'budha' ? 'selected' : '' }}>Budha</option>
                                            <option value="konghucu" {{ old('agama', $pendaftaran->agama ?? '') == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
                                            <option value="yanglainnya" {{ old('agama', $pendaftaran->agama ?? '') == 'yanglainnya' ? 'selected' : '' }}>Yang Lainnya</option>
                                        </select>
                                        @error('agama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kebangsaan">Kebangsaan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('kebangsaan') is-invalid @enderror" id="kebangsaan" name="kebangsaan" value="{{ old('kebangsaan', $pendaftaran->kebangsaan ?? '') }}" required>
                                        @error('kebangsaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $pendaftaran->email ?? '') }}" required>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $pendaftaran->phone ?? '') }}" required>
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat Sekarang <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address', $pendaftaran->address ?? '') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamatktp">Alamat Sesuai KTP <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamatktp') is-invalid @enderror" id="alamatktp" name="alamatktp" rows="3" required>{{ old('alamatktp', $pendaftaran->alamatktp ?? '') }}</textarea>
                                @error('alamatktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label for="photo">Foto</label>
                                @if($pendaftaran->photo)
                                    <p>Foto saat ini: <a href="{{ asset('storage/' . $pendaftaran->photo) }}" target="_blank">{{ $pendaftaran->photo }}</a></p> {{-- Sesuaikan path storage jika berbeda --}}
                                @else
                                    <p>Belum ada foto.</p>
                                @endif
                                <input type="file" class="form-control-file @error('photo') is-invalid @enderror" id="photo" name="photo">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                             {{-- Session ID biasanya tidak diedit manual --}}
                             {{-- <input type="hidden" name="session_id" value="{{ $pendaftaran->session_id ?? session()->getId() }}"> --}}
                        </fieldset>
                        <hr>

                        <fieldset class="mb-4">
                            <legend>Saksi Pihak Mualaf (Saksi 1)</legend>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="saksi_name">Nama Saksi 1</label>
                                        <input type="text" class="form-control @error('saksi_name') is-invalid @enderror" id="saksi_name" name="saksi_name" value="{{ old('saksi_name', $pendaftaran->saksi->saksi_name ?? '') }}">
                                        @error('saksi_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="saksi_nik">NIK Saksi 1</label>
                                        <input type="text" class="form-control @error('saksi_nik') is-invalid @enderror" id="saksi_nik" name="saksi_nik" value="{{ old('saksi_nik', $pendaftaran->saksi->saksi_nik ?? '') }}">
                                        @error('saksi_nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender_saksi">Jenis Kelamin Saksi 1</label>
                                        <select class="form-control @error('gender_saksi') is-invalid @enderror" id="gender_saksi" name="gender_saksi">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('gender_saksi', $pendaftaran->saksi->gender_saksi ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('gender_saksi', $pendaftaran->saksi->gender_saksi ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender_saksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pekerjaan_saksi">Pekerjaan Saksi 1</label>
                                        <input type="text" class="form-control @error('pekerjaan_saksi') is-invalid @enderror" id="pekerjaan_saksi" name="pekerjaan_saksi" value="{{ old('pekerjaan_saksi', $pendaftaran->saksi->pekerjaan_saksi ?? '') }}">
                                        @error('pekerjaan_saksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamatsaksi">Alamat Saksi 1</label>
                                <textarea class="form-control @error('alamatsaksi') is-invalid @enderror" id="alamatsaksi" name="alamatsaksi" rows="3">{{ old('alamatsaksi', $pendaftaran->saksi->alamatsaksi ?? '') }}</textarea>
                                @error('alamatsaksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </fieldset>
                        <hr>

                        <fieldset class="mb-4">
                            <legend>Saksi Pihak Masjid (Saksi 2) <span class="text-danger">*</span></legend>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="saksi_name2">Nama Saksi 2 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('saksi_name2') is-invalid @enderror" id="saksi_name2" name="saksi_name2" value="{{ old('saksi_name2', $pendaftaran->saksi->saksi_name2 ?? '') }}" required>
                                        @error('saksi_name2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="saksinik2">NIK Saksi 2 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('saksinik2') is-invalid @enderror" id="saksinik2" name="saksinik2" value="{{ old('saksinik2', $pendaftaran->saksi->saksinik2 ?? '') }}" required>
                                        @error('saksinik2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender_saksi2">Jenis Kelamin Saksi 2 <span class="text-danger">*</span></label>
                                        <select class="form-control @error('gender_saksi2') is-invalid @enderror" id="gender_saksi2" name="gender_saksi2" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('gender_saksi2', $pendaftaran->saksi->gender_saksi2 ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('gender_saksi2', $pendaftaran->saksi->gender_saksi2 ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender_saksi2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pekerjaan_saksi2">Pekerjaan Saksi 2 <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('pekerjaan_saksi2') is-invalid @enderror" id="pekerjaan_saksi2" name="pekerjaan_saksi2" value="{{ old('pekerjaan_saksi2', $pendaftaran->saksi->pekerjaan_saksi2 ?? '') }}" required>
                                        @error('pekerjaan_saksi2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamatsaksi2">Alamat Saksi 2 <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamatsaksi2') is-invalid @enderror" id="alamatsaksi2" name="alamatsaksi2" rows="3" required>{{ old('alamatsaksi2', $pendaftaran->saksi->alamatsaksi2 ?? '') }}</textarea>
                                @error('alamatsaksi2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </fieldset>
                        <hr>

                        <fieldset class="mb-4">
                            <legend>Pembimbing Ikrar</legend>
                            <div class="form-group">
                                <label for="nama_pembimbing_ikrar">Nama Pembimbing Ikrar</label>
                                <input type="text" class="form-control @error('nama_pembimbing_ikrar') is-invalid @enderror" id="nama_pembimbing_ikrar" name="nama_pembimbing_ikrar" value="{{ old('nama_pembimbing_ikrar', $pendaftaran->nama_pembimbing_ikrar ?? '') }}">
                                @error('nama_pembimbing_ikrar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('admin.mualaf.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
