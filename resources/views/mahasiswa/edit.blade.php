@extends('layouts.mahasiswa')

@section('title', 'Edit Profil - KampusCare')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="fas fa-user-edit text-primary me-2"></i> Edit Profil & Ganti Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-2">
                            <ul class="mb-0 pl-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted text-uppercase small">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama ?? $mahasiswa->name) }}" class="form-control p-2.5" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted text-uppercase small">Email / Username</label>
                            <input type="email" name="email" value="{{ old('email', $mahasiswa->email ?? $mahasiswa->username) }}" class="form-control p-2.5" required>
                        </div>

                        <div class="alert alert-warning border-0 bg-light-warning p-3 rounded-2 text-dark mb-4" style="background-color: #fff3cd;">
                            <i class="fas fa-info-circle me-1 text-warning"></i> 
                            <small class="fw-medium">Kosongkan kolom sandi di bawah ini jika tidak ingin mengubah password lama.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted text-uppercase small">Password Baru</label>
                            <input type="password" name="password" class="form-control p-2.5" placeholder="Minimal 6 karakter">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-muted text-uppercase small">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control p-2.5" placeholder="Ulangi password baru">
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('mahasiswa.profile') }}" class="btn btn-light px-4 border">
                                Kembali
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection