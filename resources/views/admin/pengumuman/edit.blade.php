@extends('layouts.admin')

@section('header', 'Edit Pengumuman')

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

        <form method="POST" action="{{ route('pengumuman.update', $pengumuman->id_pengumuman) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Judul Pengumuman</label>
                <input type="text" name="judul" class="form-control"
                       value="{{ old('judul', $pengumuman->judul) }}" required>
            </div>
            <div class="form-group">
                <label>Isi Pengumuman</label>
                <textarea name="isi" class="form-control" rows="6"
                          required>{{ old('isi', $pengumuman->isi) }}</textarea>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input"
                           id="is_active" name="is_active"
                           {{ $pengumuman->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">
                        Tampilkan di beranda mahasiswa
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection