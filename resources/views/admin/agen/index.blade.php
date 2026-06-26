@extends('layouts.admin')

@section('header', 'Manajemen Agen')

@section('main')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Agen</h3>
        <a href="{{ route('agen.create') }}" class="btn btn-primary btn-sm">+ Tambah Agen</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Unit Kerja</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agens as $i => $agen)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $agen->nama }}</td>
                    <td>{{ $agen->email }}</td>
                    <td>
                        @if($agen->level_agen == 1)
                            <span class="badge badge-info">Level 1 - Puslia</span>
                        @elseif($agen->level_agen == 2)
                            <span class="badge badge-warning">Level 2 - BAAK</span>
                        @else
                            <span class="badge badge-danger">Level 3 - Wakil Rektor</span>
                        @endif
                    </td>
                    <td>{{ $agen->unit_kerja ?? '-' }}</td>
                    <td>
                        @if($agen->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('agen.edit', $agen->id_agen) }}"
                           class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('agen.destroy', $agen->id_agen) }}"
                              method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Nonaktifkan agen ini?')">
                                Nonaktifkan
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada agen</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $agens->links() }}
    </div>
</div>

@endsection