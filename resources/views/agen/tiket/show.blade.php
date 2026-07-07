@extends('layouts.agen')

@section('title', 'Detail Tiket')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Detail Tiket #{{ $tiket->id_tiket }}</h3>
    <a href="{{ route('agen.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    {{-- Info Tiket --}}
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $tiket->judul }}</h5>
                <p class="card-text">{{ $tiket->deskripsi }}</p>

                @if($tiket->is_urgent)
                <div class="alert alert-danger py-2">
                    <i class="fas fa-exclamation-triangle"></i> <strong>URGENT:</strong> {{ $tiket->alasan_urgent }}
                </div>
                @endif

                <hr>

                <div class="row small text-muted">
                    <div class="col-md-6 mb-2">
                        <strong>Mahasiswa:</strong> {{ $tiket->mahasiswa->nama ?? '-' }}
                        ({{ $tiket->mahasiswa->nim ?? '-' }})
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Kategori:</strong> {{ $tiket->kategori->nama_kategori ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Prioritas:</strong>
                        <span class="badge bg-{{ $tiket->prioritas == 'tinggi' ? 'danger' : ($tiket->prioritas == 'sedang' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($tiket->prioritas) }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong>
                        <span class="badge bg-info text-dark">{{ str_replace('_', ' ', $tiket->status) }}</span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Level Saat Ini:</strong> {{ $tiket->level_saat_ini }}
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Agen Penanggung Jawab:</strong> {{ $tiket->agen->nama ?? 'Belum ada' }}
                    </div>
                    @if($tiket->lampiran)
                    <div class="col-md-6 mb-2">
                        <strong>Lampiran:</strong>
                        <a href="{{ asset('storage/' . $tiket->lampiran) }}" target="_blank">Lihat file</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Komentar / Percakapan --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <i class="fas fa-comments"></i> Percakapan
            </div>
            <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                @forelse($komentars as $komentar)
                <div class="mb-3 pb-2 border-bottom">
                    <div class="d-flex justify-content-between">
                        <strong class="{{ $komentar->pengirim_tipe == 'agen' ? 'text-primary' : 'text-success' }}">
                            {{ ucfirst($komentar->pengirim_tipe) }}
                            @if($komentar->is_internal)
                                <span class="badge bg-secondary">Internal</span>
                            @endif
                        </strong>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($komentar->waktu_kirim)->diffForHumans() }}</small>
                    </div>
                    <div>{{ $komentar->pesan }}</div>
                </div>
                @empty
                <p class="text-muted text-center mb-0">Belum ada percakapan.</p>
                @endforelse
            </div>
            <div class="card-footer bg-white">
                <form method="POST" action="{{ route('agen.tiket.komentar', $tiket->id_tiket) }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="pesan" class="form-control" placeholder="Tulis balasan..." required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Aksi --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <i class="fas fa-cogs"></i> Aksi
            </div>
            <div class="card-body d-grid gap-2">

                @if(is_null($tiket->id_agen))
                    <form method="POST" action="{{ route('agen.tiket.proses', $tiket->id_tiket) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-hand-paper"></i> Ambil & Proses Tiket
                        </button>
                    </form>
                @elseif(!in_array($tiket->status, ['selesai', 'ditutup', 'dibatalkan']))
                    @if($tiket->status != 'diproses')
                    <form method="POST" action="{{ route('agen.tiket.proses', $tiket->id_tiket) }}">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-play"></i> Proses Tiket
                        </button>
                    </form>
                    @endif

                    <form method="POST" action="{{ route('agen.tiket.selesai', $tiket->id_tiket) }}"
                          onsubmit="return confirm('Yakin tiket ini sudah selesai?')">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check-circle"></i> Tandai Selesai
                        </button>
                    </form>
                @else
                    <div class="alert alert-success mb-0 text-center">
                        <i class="fas fa-check"></i> Tiket sudah {{ $tiket->status }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection