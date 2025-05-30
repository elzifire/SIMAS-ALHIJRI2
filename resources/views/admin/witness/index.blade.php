@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Saksi</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('admin.witness.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </a>
                                </div>
                                <h4>Data Saksi</h4>
                            </div>
                            <div class="card-body">
                                <!-- Form Pencarian -->
                                <div class="mb-3">
                                    <form action="{{ route('admin.witness.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="q" class="form-control" placeholder="Cari nama saksi..." value="{{ request()->q }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Tabel -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 10%;">No</th>
                                                <th>Nama</th>
                                                <th class="text-center" style="width: 20%;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($witnesses as $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.witness.edit', $item->id) }}"
                                                           class="btn btn-warning btn-sm mr-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('admin.witness.destroy', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data saksi.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-end">
                                    {{ $witnesses->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            // SweetAlert untuk konfirmasi hapus
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection