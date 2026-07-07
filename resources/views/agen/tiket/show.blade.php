@extends('layouts.agen')

@section('title', 'Detail Tiket')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Detail Tiket</h3>
        <small class="text-muted">Lihat informasi dan proses tiket mahasiswa.</small>
    </div>

    <a href="{{ route('agen.dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">

    <div class="col-lg-8">

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong>{{ $tiket->judul }}</strong>

                @if($tiket->is_urgent)
                    <span class="badge bg-danger ms-2">
                        URGENT
                    </span>
                @endif
            </div>

            <div class="card-body">

                @if($tiket->is_urgent)
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    {{ $tiket->alasan_urgent }}
                </div>
                @endif

                <div class="row mb-3">

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Mahasiswa</label>
                        <div>{{ $tiket->mahasiswa->nama ?? '-' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">NIM</label>
                        <div>{{ $tiket->mahasiswa->nim ?? '-' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Kategori</label>
                        <div>{{ $tiket->kategori->nama_kategori ?? '-' }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Level</label>
                        <div>{{ $tiket->level_saat_ini }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Status</label>

                        <div>

                            @if($tiket->status=='baru')
                                <span class="badge bg-primary">Baru</span>

                            @elseif($tiket->status=='diproses')
                                <span class="badge bg-warning text-dark">Diproses</span>

                            @elseif($tiket->status=='selesai')
                                <span class="badge bg-success">Selesai</span>

                            @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst(str_replace('_',' ',$tiket->status)) }}
                                </span>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Prioritas</label>

                        <div>

                            @if($tiket->prioritas=='tinggi')
                                <span class="badge bg-danger">Tinggi</span>

                            @elseif($tiket->prioritas=='sedang')
                                <span class="badge bg-warning text-dark">Sedang</span>

                            @else
                                <span class="badge bg-secondary">Rendah</span>

                            @endif

                        </div>
                    </div>

                </div>

                <hr>

                <label class="text-muted small">Deskripsi</label>

                <p class="mb-0">
                    {{ $tiket->deskripsi }}
                </p>

            </div>

        </div>

        <div class="card shadow-sm">

            <div class="card-header bg-white">
                <i class="fas fa-comments me-2"></i>
                Percakapan
            </div>

            <div class="card-body">

                @forelse($komentars as $komentar)

                    <div class="border rounded p-3 mb-3">

                        <div class="d-flex justify-content-between">

                            <strong>
                                {{ ucfirst($komentar->pengirim_tipe) }}
                            </strong>

                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($komentar->waktu_kirim)->diffForHumans() }}
                            </small>

                        </div>

                        <div class="mt-2">
                            {{ $komentar->pesan }}
                        </div>

                    </div>

                @empty

                    <p class="text-muted text-center">
                        Belum ada komentar.
                    </p>

                @endforelse

            </div>

            <div class="card-footer bg-white">

                <form action="{{ route('agen.tiket.komentar',$tiket->id_tiket) }}" method="POST">

                    @csrf

                    <div class="input-group">

                        <input
                            type="text"
                            name="pesan"
                            class="form-control"
                            placeholder="Tulis komentar..."
                            required>

                        <button class="btn btn-primary">
                            Kirim
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card shadow-sm">

            <div class="card-header bg-white">
                Aksi Tiket
            </div>

            <div class="card-body d-grid gap-2">

                @if(is_null($tiket->id_agen))

                    <form action="{{ route('agen.tiket.proses',$tiket->id_tiket) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary w-100">
                            Ambil Tiket
                        </button>
                    </form>

                @elseif($tiket->status!='selesai')

                    @if($tiket->status!='diproses')

                    <form action="{{ route('agen.tiket.proses',$tiket->id_tiket) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning w-100">
                            Proses Tiket
                        </button>
                    </form>

                    @endif

                    <form action="{{ route('agen.tiket.selesai',$tiket->id_tiket) }}" method="POST">
                        @csrf
                        <button class="btn btn-success w-100">
                            Tandai Selesai
                        </button>
                    </form>

                @else

                    <div class="alert alert-success text-center mb-0">
                        Tiket telah selesai.
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection