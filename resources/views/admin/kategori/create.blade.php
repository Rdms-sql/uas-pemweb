@extends('layouts.admin')

@section('header', 'Tambah Kategori Baru')

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

        <form method="POST" action="{{ route('kategori.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control"
                       value="{{ old('nama_kategori') }}" required
                       placeholder="cth: Perpustakaan, Administrasi Akademik">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"
                          placeholder="Jelaskan jenis masalah dalam kategori ini">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="form-group">
                <label>Level Agen Default</label>
                <select name="level_agen_default" class="form-control" required>
                    <option value="">-- Pilih Level --</option>
                    <option value="1" {{ old('level_agen_default') == '1' ? 'selected' : '' }}>
                        Level 1 - Puslia
                    </option>
                    <option value="2" {{ old('level_agen_default') == '2' ? 'selected' : '' }}>
                        Level 2 - BAAK
                    </option>
                    <option value="3" {{ old('level_agen_default') == '3' ? 'selected' : '' }}>
                        Level 3 - Wakil Rektor
                    </option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>SLA Normal (jam)</label>
                        <input type="number" name="sla_jam_normal" class="form-control"
                               value="{{ old('sla_jam_normal', 24) }}" min="1" required>
                        <small class="text-muted">Batas waktu penanganan tiket normal</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>SLA Urgent (jam)</label>
                        <input type="number" name="sla_jam_urgent" class="form-control"
                               value="{{ old('sla_jam_urgent', 12) }}" min="1" required>
                        <small class="text-muted">Batas waktu penanganan tiket urgent</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection