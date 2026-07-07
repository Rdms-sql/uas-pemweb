@extends('layouts.agen')

@section('title', 'Dashboard Agen')

@section('content')
<h3 class="mb-4">Dashboard Agen - Level {{ Auth::guard('agen')->user()->level_agen }}</h3>

{{-- Kartu Statistik --}}
<div class="row mb-4">
    <div class="col-md-3 col-6 mb-3">
        <div class="bg-white rounded shadow-sm p-3 text-center">
            <div class="text-muted small">Total Tiket</div>
            <div class="fs-3 fw-bold">{{ $total }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="bg-white rounded shadow-sm p-3 text-center">
            <div class="text-muted small">Baru</div>
            <div class="fs-3 fw-bold text-primary">{{ $pending }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="bg-white rounded shadow-sm p-3 text-center">
            <div class="text-muted small">Diproses</div>
            <div class="fs-3 fw-bold text-warning">{{ $diproses }}</div>
        </div>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <div class="bg-white rounded shadow-sm p-3 text-center">
            <div class="text-muted small">Selesai</div>
            <div class="fs-3 fw-bold text-success">{{ $selesai }}</div>
        </div>
    </div>
</div>

{{-- Tiket Menunggu Diambil --}}
<div class="row mb-4">
    <div class="col-12">
        <h5><i class="fas fa-inbox text-primary"></i> Tiket Menunggu Diambil</h5>
        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tiketBaru as $tiket)
                    <tr>
                        <td>{{ $tiket->judul }}</td>
                        <td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $tiket->prioritas == 'tinggi' ? 'danger' : ($tiket->prioritas == 'sedang' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($tiket->prioritas) }}
                            </span>
                        </td>
                        <td><span class="badge bg-info text-dark">{{ str_replace('_', ' ', $tiket->status) }}</span></td>
                        <td>{{ $tiket->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('agen.tiket.show', $tiket->id_tiket) }}" class="btn btn-sm btn-outline-primary">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada tiket menunggu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Tiket Sedang Ditangani --}}
<div class="row">
    <div class="col-12">
        <h5><i class="fas fa-tasks text-success"></i> Tiket Sedang Saya Tangani</h5>
        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>SLA Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tiketSaya as $tiket)
                    <tr>
                        <td>{{ $tiket->judul }}</td>
                        <td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td>
                        <td><span class="badge bg-warning text-dark">{{ str_replace('_', ' ', $tiket->status) }}</span></td>
                        <td>{{ $tiket->sla_deadline ? $tiket->sla_deadline->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            <a href="{{ route('agen.tiket.show', $tiket->id_tiket) }}" class="btn btn-sm btn-outline-success">
                                Kelola
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada tiket yang kamu tangani.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection