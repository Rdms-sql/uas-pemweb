@extends('layouts.mahasiswa')

@section('title', 'Laporan Saya - KampusCare')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">📋 Semua Laporan Saya</h5>
    <a href="/mahasiswa/tiket/buat" class="btn btn-primary btn-sm">+ Laporan Baru</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Prioritas</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tikets as $i => $tiket)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        {{ $tiket->judul }}
                        @if($tiket->is_urgent)
                            <span class="badge bg-danger">URGENT</span>
                        @endif
                    </td>
                    <td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td>
                    <td><span class="badge bg-secondary">{{ $tiket->status }}</span></td>
                    <td>
                        @if($tiket->prioritas == 'tinggi')
                            <span class="badge bg-danger">Tinggi</span>
                        @elseif($tiket->prioritas == 'sedang')
                            <span class="badge bg-warning">Sedang</span>
                        @else
                            <span class="badge bg-success">Rendah</span>
                        @endif
                    </td>
                    <td>{{ $tiket->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="/mahasiswa/tiket/{{ $tiket->id_tiket }}"
                           class="btn btn-sm btn-outline-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">
                        Belum ada laporan. <a href="/mahasiswa/tiket/buat">Buat sekarang!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-3">{{ $tikets->links() }}</div>
    </div>
</div>

@endsection