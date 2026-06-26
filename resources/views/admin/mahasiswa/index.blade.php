@extends('layouts.admin')

@section('header', 'Manajemen Mahasiswa')

@section('main')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Mahasiswa</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Prodi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswas as $i => $mhs)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->email }}</td>
                    <td>{{ $mhs->program_studi }}</td>
                    <td>
                        @if($mhs->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('mahasiswa.edit', $mhs->id_mahasiswa) }}"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('mahasiswa.destroy', $mhs->id_mahasiswa) }}"
                              method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Nonaktifkan akun ini?')">
                                Nonaktifkan
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $mahasiswas->links() }}
    </div>
</div>

@endsection