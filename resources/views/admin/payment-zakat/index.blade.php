@extends('layouts.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Muzakki</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-money-bill-wave"></i> Daftar Muzakki</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.payment-zakat.index') }}" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="q"
                                        placeholder="cari berdasarkan nama donatur">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                                            CARI</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 5%;">No</th>
                                        <th>Nama Donatur</th>
                                        <th>Jenis Zakat</th>
                                        <th>Jumlah Zakat</th>
                                        <th>Status</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Bukti Pembayaran</th>
                                        <th style="text-align: center; width: 15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $no => $payment)
                                        <tr>
                                            <td style="text-align: center;">
                                                {{ ++$no + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                                            <td>{{ $payment->name }}</td>
                                            <td>{{ ucfirst($payment->zakat_type) }}</td>
                                            <td>Rp {{ number_format($payment->amount, 2, ',', '.') }}</td>
                                            <td>
                                                @if ($payment->is_verified)
                                                    <span class="badge badge-success">Terverifikasi</span>
                                                @else
                                                    <span class="badge badge-warning">Belum Diverifikasi</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($payment->proof)
                                                    <a href="{{ asset($payment->proof) }}" target="_blank">
                                                        <img src="{{ asset($payment->proof) }}" alt="Bukti"
                                                            width="80">
                                                    </a>
                                                @else
                                                    <span class="text-muted">Belum Upload</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @can('payment-zakat.update')
                                                    @if (!$payment->is_verified)
                                                        <form action="{{ route('admin.payment-zakat.update', $payment->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                onclick="return confirm('Yakin ingin ACC pembayaran ini?')">
                                                                <i class="fa fa-check-circle"></i> ACC
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary" disabled><i
                                                                class="fa fa-check-circle"></i> ACC</button>
                                                    @endif
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-right">
                                {{ $payments->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
