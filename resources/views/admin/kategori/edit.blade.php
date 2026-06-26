@extends('layouts.admin')

@section('header', 'Edit Kategori')

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

        <form method="POST" action="{{ route('kategori.update', $kategori->id_kategori) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control"
                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
            </div>
            <div class="form-group">
                <label>Level Agen Default</label>
                <select name="level_agen_default" class="form-control" required>
                    <option value="1" {{ $kategori->level_agen_default == '1' ? 'selected' : '' }}>
                        Level 1 - Puslia
                    </option>
                    <option value="2" {{ $kategori->level_agen_default == '2' ? 'selected' : '' }}>
                        Level 2 - BAAK
                    </option>
                    <option value="3" {{ $kategori->level_agen_default == '3' ? 'selected' : '' }}>
                        Level 3 - Wakil Rektor
                    </option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>SLA Normal (jam)</label>
                        <input type="number" name="sla_jam_normal" class="form-control"
                               value="{{ old('sla_jam_normal', $kategori->sla_jam_normal) }}" min="1" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>SLA Urgent (jam)</label>
                        <input type="number" name="sla_jam_urgent" class="form-control"
                               value="{{ old('sla_jam_urgent', $kategori->sla_jam_urgent) }}" min="1" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

@endsection