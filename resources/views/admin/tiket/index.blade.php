@extends('layouts.admin')

@section('header', 'Monitor Semua Tiket')

@section('main')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Semua Tiket</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Mahasiswa</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Urgent</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tikets as $i => $tiket)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $tiket->judul }}</td>
                    <td>{{ $tiket->mahasiswa->nama ?? '-' }}</td>
                    <td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td>
                    <td><span class="badge badge-info">{{ $tiket->status }}</span></td>
                    <td>
                        @if($tiket->is_urgent)
                            <span class="badge badge-danger">⚠ URGENT</span>
                        @else
                            <span class="badge badge-secondary">Normal</span>
                        @endif
                    </td>
                    <td>Level {{ $tiket->level_saat_ini }}</td>
                    <td>
                        <a href="{{ route('tiket.show', $tiket->id_tiket) }}"
                           class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada tiket</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $tikets->links() }}
    </div>
</div>

@endsection