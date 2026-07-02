@extends('layouts.mahasiswa')

@section('title', 'Detail Laporan - KampusCare')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        @if($tiket->is_urgent)
        <div class="alert alert-danger">
            ⚠️ <strong>Laporan ini ditandai URGENT oleh sistem</strong> — diprioritaskan penanganannya.
        </div>
        @endif

        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0">{{ $tiket->judul }}</h5>
                <span class="badge bg-light text-dark">{{ $tiket->status }}</span>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="150">Kategori</th><td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td></tr>
                    <tr><th>Status</th><td><span class="badge bg-secondary">{{ $tiket->status }}</span></td></tr>
                    <tr>
                        <th>Prioritas</th>
                        <td>
                            @if($tiket->prioritas == 'tinggi')
                                <span class="badge bg-danger">Tinggi</span>
                            @else
                                <span class="badge bg-success">Rendah</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Level Penanganan</th><td>Level {{ $tiket->level_saat_ini }}</td></tr>
                    <tr><th>SLA Deadline</th><td>{{ $tiket->sla_deadline ?? '-' }}</td></tr>
                    <tr><th>Tanggal Lapor</th><td>{{ $tiket->created_at->format('d/m/Y H:i') }}</td></tr>
                </table>
                <hr>
                <h6>Deskripsi Masalah:</h6>
                <p class="text-muted mb-0">{{ $tiket->deskripsi }}</p>

                {{-- ======================================================= --}}
                {{-- STEP 3: TAMPILKAN FORM RATING JIKA STATUSNYA SUDAH SELESAI --}}
                {{-- ======================================================= --}}
                @if($tiket->status == 'selesai' || $tiket->status == 'Selesai')
                    <hr>
                    @if(empty($tiket->rating))
                        {{-- Jika Belum Mengisi Rating --}}
                        <div class="card border-warning shadow-sm mt-3">
                            <div class="card-header bg-warning text-white py-2">
                                <h6 class="card-title mb-0 fw-bold">
                                    <i class="fas fa-star me-1"></i> Berikan Penilaian Laporan
                                </h6>
                            </div>
                            <div class="card-body p-3">
                                <p class="small text-muted mb-3">Bagaimana penanganan laporan kamu oleh tim agen kami? Masukan kamu sangat berharga!</p>
                                
                                <form action="{{ route('mahasiswa.tiket.rating', $tiket->id_tiket) }}" method="POST">
                                    @csrf
                                    
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-secondary">Pilih Bintang:</label>
                                        <select name="rating" class="form-select w-auto" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                                            <option value="4">⭐⭐⭐⭐ (Puas)</option>
                                            <option value="3">⭐⭐⭐ (Cukup)</option>
                                            <option value="2">⭐⭐ (Kurang Puas)</option>
                                            <option value="1">⭐ (Sangat Kecewa)</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-secondary">Ulasan / Komentar (Opsional):</label>
                                        <textarea name="ulasan" class="form-control" rows="3" placeholder="Tulis masukan atau tingkat kepuasan kamu di sini..."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-warning btn-sm text-white fw-semibold px-3 shadow-sm">
                                        <i class="fas fa-paper-plane me-1"></i> Kirim Penilaian
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Jika Sudah Pernah Mengisi Rating --}}
                        <div class="card bg-light border border-light-subtle shadow-sm mt-3">
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-check-circle text-success me-1"></i> Penilaian Laporan Anda</h6>
                                <div class="fs-5 text-warning mb-2">
                                    @for($i = 1; $i <= $tiket->rating; $i++)
                                        ⭐
                                    @endfor
                                </div>
                                @if($tiket->ulasan)
                                    <div class="p-2 bg-white rounded border border-light small text-secondary italic">
                                        "{{ $tiket->ulasan }}"
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
                {{-- ======================================================= --}}

            </div>
        </div>

    </div>
</div>

@endsection