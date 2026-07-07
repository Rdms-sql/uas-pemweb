@extends('layouts.agen')

@section('title', 'Dashboard Agen')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-1">Dashboard Agen</h3>
        <small class="text-muted">
            Selamat datang, <strong>{{ Auth::guard('agen')->user()->nama }}</strong>.
            Kelola tiket sesuai level agen Anda.
        </small>
    </div>
</div>

{{-- Statistik --}}
<div class="row mb-4">

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <i class="fas fa-ticket-alt fa-2x text-primary mb-2"></i>
                <h6 class="text-muted mb-1">Total Tiket</h6>
                <h2 class="fw-bold">{{ $total }}</h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <i class="fas fa-folder-open fa-2x text-info mb-2"></i>
                <h6 class="text-muted mb-1">Baru</h6>
                <h2 class="fw-bold text-info">{{ $pending }}</h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <i class="fas fa-spinner fa-2x text-warning mb-2"></i>
                <h6 class="text-muted mb-1">Diproses</h6>
                <h2 class="fw-bold text-warning">{{ $diproses }}</h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h6 class="text-muted mb-1">Selesai</h6>
                <h2 class="fw-bold text-success">{{ $selesai }}</h2>
            </div>
        </div>
    </div>

</div>

{{-- Tiket Menunggu --}}
<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-inbox text-primary me-2"></i>
            Tiket Menunggu Diambil
        </h5>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="110">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($tiketBaru as $tiket)

                    <tr>

                        <td>

                            <strong>{{ $tiket->judul }}</strong>

                            @if($tiket->is_urgent)
                                <span class="badge bg-danger ms-1">
                                    URGENT
                                </span>
                            @endif

                        </td>

                        <td>
                            {{ $tiket->kategori->nama_kategori ?? '-' }}
                        </td>

                        <td>

                            @if($tiket->prioritas=='tinggi')

                                <span class="badge bg-danger">
                                    Tinggi
                                </span>

                            @elseif($tiket->prioritas=='sedang')

                                <span class="badge bg-warning text-dark">
                                    Sedang
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Rendah
                                </span>

                            @endif

                        </td>

                        <td>

                            @if($tiket->status=='baru')

                                <span class="badge bg-primary">
                                    Baru
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ ucfirst(str_replace('_',' ',$tiket->status)) }}
                                </span>

                            @endif

                        </td>

                        <td>

                            <small class="text-muted">
                                {{ $tiket->created_at->diffForHumans() }}
                            </small>

                        </td>

                        <td>

                            <a href="{{ route('agen.tiket.show',$tiket->id_tiket) }}"
                               class="btn btn-sm btn-outline-primary">

                                Lihat

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center py-5">

                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>

                            <p class="text-muted mb-0">
                                Belum ada tiket yang menunggu.
                            </p>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- Tiket Saya --}}
<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            <i class="fas fa-user-cog text-success me-2"></i>

            Tiket Sedang Saya Tangani

        </h5>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th width="120">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($tiketSaya as $tiket)

                    <tr>

                        <td>

                            <strong>{{ $tiket->judul }}</strong>

                        </td>

                        <td>

                            {{ $tiket->kategori->nama_kategori ?? '-' }}

                        </td>

                        <td>

                            @if($tiket->status=='diproses')

                                <span class="badge bg-warning text-dark">
                                    Diproses
                                </span>

                            @elseif($tiket->status=='selesai')

                                <span class="badge bg-success">
                                    Selesai
                                </span>

                            @elseif($tiket->status=='baru')

                                <span class="badge bg-primary">
                                    Baru
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    {{ ucfirst(str_replace('_',' ',$tiket->status)) }}
                                </span>

                            @endif

                        </td>

                        <td>

                            @if($tiket->prioritas=='tinggi')

                                <span class="badge bg-danger">
                                    Tinggi
                                </span>

                            @elseif($tiket->prioritas=='sedang')

                                <span class="badge bg-warning text-dark">
                                    Sedang
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Rendah
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('agen.tiket.show',$tiket->id_tiket) }}"
                               class="btn btn-sm btn-outline-success">

                                Kelola

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-5">

                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>

                            <p class="text-muted mb-0">
                                Belum ada tiket yang sedang Anda tangani.
                            </p>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection