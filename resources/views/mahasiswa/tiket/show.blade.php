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
                <p class="text-muted">{{ $tiket->deskripsi }}</p>
            </div>
        </div>

    </div>
</div>

@endsection