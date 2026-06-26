@extends('layouts.admin')

@section('header', 'Edit Data Agen')

@section('main')

<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('agen.update', $agen->id_agen) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama', $agen->nama) }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $agen->email) }}" required>
            </div>
            <div class="form-group">
                <label>Level Agen</label>
                <select name="level_agen" class="form-control" required>
                    <option value="1" {{ $agen->level_agen == '1' ? 'selected' : '' }}>
                        Level 1 - Puslia
                    </option>
                    <option value="2" {{ $agen->level_agen == '2' ? 'selected' : '' }}>
                        Level 2 - BAAK
                    </option>
                    <option value="3" {{ $agen->level_agen == '3' ? 'selected' : '' }}>
                        Level 3 - Wakil Rektor
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Unit Kerja</label>
                <input type="text" name="unit_kerja" class="form-control"
                       value="{{ old('unit_kerja', $agen->unit_kerja) }}">
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control"
                       value="{{ old('no_telepon', $agen->no_telepon) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('agen.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection