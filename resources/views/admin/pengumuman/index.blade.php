@extends('layouts.admin')

@section('header', 'Manajemen Pengumuman')

@section('main')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Pengumuman</h3>
        <a href="{{ route('pengumuman.create') }}" class="btn btn-primary btn-sm">+ Buat Pengumuman</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Isi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengumumans as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $p->judul }}</strong></td>
                    <td>{{ Str::limit($p->isi, 80) }}</td>
                    <td>
                        @if($p->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('pengumuman.edit', $p->id_pengumuman) }}"
                           class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pengumuman.destroy', $p->id_pengumuman) }}"
                              method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus pengumuman ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada pengumuman</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $pengumumans->links() }}
    </div>
</div>

@endsection