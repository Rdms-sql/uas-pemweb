@extends('layouts.admin')

@section('header', 'Manajemen Kategori')

@section('main')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Kategori Tiket</h3>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">+ Tambah Kategori</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Level Default</th>
                    <th>SLA Normal</th>
                    <th>SLA Urgent</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $kat)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <strong>{{ $kat->nama_kategori }}</strong>
                        <br><small class="text-muted">{{ $kat->deskripsi }}</small>
                    </td>
                    <td>
                        @if($kat->level_agen_default == 1)
                            <span class="badge badge-info">Level 1 - Puslia</span>
                        @elseif($kat->level_agen_default == 2)
                            <span class="badge badge-warning">Level 2 - BAAK</span>
                        @else
                            <span class="badge badge-danger">Level 3 - Wakil Rektor</span>
                        @endif
                    </td>
                    <td>{{ $kat->sla_jam_normal }} jam</td>
                    <td>{{ $kat->sla_jam_urgent }} jam</td>
                    <td>
                        @if($kat->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('kategori.edit', $kat->id_kategori) }}"
                           class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('kategori.destroy', $kat->id_kategori) }}"
                              method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus kategori ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $kategoris->links() }}
    </div>
</div>

@endsection