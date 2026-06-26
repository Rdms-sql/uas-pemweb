@extends('layouts.admin')

@section('header', 'Detail Tiket')

@section('main')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>Judul</th><td>{{ $tiket->judul }}</td></tr>
            <tr><th>Mahasiswa</th><td>{{ $tiket->mahasiswa->nama ?? '-' }}</td></tr>
            <tr><th>Kategori</th><td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td></tr>
            <tr><th>Deskripsi</th><td>{{ $tiket->deskripsi }}</td></tr>
            <tr><th>Status</th><td>{{ $tiket->status }}</td></tr>
            <tr><th>Level</th><td>Level {{ $tiket->level_saat_ini }}</td></tr>
            <tr><th>Urgent</th><td>{{ $tiket->is_urgent ? '⚠ YA' : 'Tidak' }}</td></tr>
            <tr><th>SLA Deadline</th><td>{{ $tiket->sla_deadline ?? '-' }}</td></tr>
            <tr><th>Dibuat</th><td>{{ $tiket->created_at }}</td></tr>
        </table>
        <a href="{{ route('tiket.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

@endsection