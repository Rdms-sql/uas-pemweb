@extends('layouts.mahasiswa')

@section('title', 'Dashboard - KampusCare')

@section('content')

{{-- Pengumuman --}}
@if($pengumumans->count() > 0)
<div class="mb-3">
    @foreach($pengumumans as $p)
    <div class="alert alert-info py-2">
        <i class="fas fa-bullhorn me-2"></i>
        <strong>{{ $p->judul }}</strong> — {{ Str::limit($p->isi, 100) }}
    </div>
    @endforeach
</div>
@endif

{{-- Tombol Aksi --}}
<div class="mb-4">
    <a href="/mahasiswa/tiket/buat" class="btn btn-primary">
        <i class="fas fa-plus-circle me-1"></i> Buat Laporan Baru
    </a>
    <a href="/mahasiswa/tiket" class="btn btn-outline-secondary ms-2">
        <i class="fas fa-list me-1"></i> Lihat Semua Laporan
    </a>
</div>

{{-- Laporan Terbaru --}}
<div class="card">
    <div class="card-header"><h5 class="mb-0">📋 Laporan Terbaru</h5></div>
    <div class="card-body p-0">
        @forelse($tikets as $tiket)
        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
            <div>
                <strong>{{ $tiket->judul }}</strong>
                @if($tiket->is_urgent)
                    <span class="badge bg-danger ms-1">URGENT</span>
                @endif
                <br>
                <small class="text-muted">{{ $tiket->created_at->diffForHumans() }}</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-secondary">{{ $tiket->status }}</span>
                <a href="/mahasiswa/tiket/{{ $tiket->id_tiket }}"
                   class="btn btn-sm btn-outline-primary">Detail</a>
            </div>
        </div>
        @empty
        <p class="text-muted text-center py-4">
            Belum ada laporan. <a href="/mahasiswa/tiket/buat">Buat laporan pertamamu!</a>
        </p>
        @endforelse
    </div>
</div>

@endsection