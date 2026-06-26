@extends('layouts.admin')

@section('header', 'Laporan & Statistik')

@section('main')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Filter Periode --}}
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan') }}" class="form-inline">
            <label class="mr-2">Periode:</label>
            <input type="month" name="periode" class="form-control mr-2"
                   value="{{ $data['periode'] }}">
            <button type="submit" class="btn btn-info mr-2">Tampilkan</button>

            <form method="POST" action="{{ route('admin.laporan.store') }}" style="display:inline">
                @csrf
                <input type="hidden" name="periode" value="{{ $data['periode'] }}">
                <button type="submit" class="btn btn-success">Simpan Laporan</button>
            </form>
        </form>
    </div>
</div>

{{-- Statistik Periode --}}
<div class="row">
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-ticket-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Tiket</span>
                <span class="info-box-number">{{ $data['total_tiket'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tiket Urgent</span>
                <span class="info-box-number">{{ $data['total_urgent'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Tiket Selesai</span>
                <span class="info-box-number">{{ $data['total_selesai'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-star"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Rata-rata Rating</span>
                <span class="info-box-number">{{ $data['rata_rating'] ?: '-' }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Tiket Per Level --}}
<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $data['tiket_level1'] }}</h3>
                <p>Tiket Level 1 (Puslia)</p>
            </div>
            <div class="icon"><i class="fas fa-headset"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $data['tiket_level2'] }}</h3>
                <p>Tiket Level 2 (BAAK)</p>
            </div>
            <div class="icon"><i class="fas fa-university"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $data['tiket_level3'] }}</h3>
                <p>Tiket Level 3 (Wakil Rektor)</p>
            </div>
            <div class="icon"><i class="fas fa-user-tie"></i></div>
        </div>
    </div>
</div>

{{-- Riwayat Laporan Tersimpan --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Laporan Tersimpan</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Tiket</th>
                    <th>Urgent</th>
                    <th>Level 1</th>
                    <th>Level 2</th>
                    <th>Level 3</th>
                    <th>Rata Rating</th>
                    <th>Tanggal Buat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $lap)
                <tr>
                    <td>{{ $lap->periode }}</td>
                    <td>{{ $lap->total_tiket }}</td>
                    <td>{{ $lap->total_tiket_urgent }}</td>
                    <td>{{ $lap->tiket_level1 }}</td>
                    <td>{{ $lap->tiket_level2 }}</td>
                    <td>{{ $lap->tiket_level3 }}</td>
                    <td>{{ $lap->rata_rating ?: '-' }}</td>
                    <td>{{ $lap->tanggal_buat }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada laporan tersimpan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $riwayat->links() }}
    </div>
</div>

@endsection