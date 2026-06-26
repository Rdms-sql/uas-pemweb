@extends('layouts.admin')

@section('header', 'Tambah Agen Baru')

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

        <form method="POST" action="{{ route('agen.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control"
                       value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Level Agen</label>
                <select name="level_agen" class="form-control" required>
                    <option value="">-- Pilih Level --</option>
                    <option value="1" {{ old('level_agen') == '1' ? 'selected' : '' }}>
                        Level 1 - Puslia
                    </option>
                    <option value="2" {{ old('level_agen') == '2' ? 'selected' : '' }}>
                        Level 2 - BAAK
                    </option>
                    <option value="3" {{ old('level_agen') == '3' ? 'selected' : '' }}>
                        Level 3 - Wakil Rektor
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Unit Kerja</label>
                <input type="text" name="unit_kerja" class="form-control"
                       value="{{ old('unit_kerja') }}">
            </div>
            <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control"
                       value="{{ old('no_telepon') }}">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('agen.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection