@extends('layouts.mahasiswa')

@section('title', 'Laporan Saya - KampusCare')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">📋 Semua Laporan Saya</h5>
    <a href="/mahasiswa/tiket/buat" class="btn btn-primary btn-sm">+ Laporan Baru</a>
</div>

<div class="card mb-4 border-0 shadow-sm bg-light">
    <div class="card-body p-3">
        <form action="{{ url('/mahasiswa/tiket') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari berdasarkan judul laporan..." value="{{ request('search') }}">
            </div>
            
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ url('/mahasiswa/tiket') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
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
                    <td>{{ $tikets->firstItem() + $i }}</td>
                    <td>
                        {{ $tiket->judul }}
                        @if($tiket->is_urgent)
                            <span class="badge bg-danger">URGENT</span>
                        @endif
                    </td>
                    <td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        @if($tiket->status == 'baru')
                            <span class="badge bg-info text-dark">baru</span>
                        @elseif($tiket->status == 'proses')
                            <span class="badge bg-warning text-dark">proses</span>
                        @else
                            <span class="badge bg-secondary">selesai</span>
                        @endif
                    </td>
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
                        <a href="/mahasiswa/tiket/{{ $tiket->id_tiket }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">
                        Belum ada laporan atau laporan tidak ditemukan. <a href="/mahasiswa/tiket/buat">Buat sekarang!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-3">
            {{ $tikets->links() }}
        </div>
    </div>
</div>

@endsection