@extends('layouts.mahasiswa')

@section('title', 'Profil Saya - KampusCare')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="fas fa-user-circle text-primary me-2"></i> Profil Mahasiswa
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 11px; tracking-wider: 1px;">Nama Lengkap</small>
                        <span class="fs-5 fw-semibold text-secondary">{{ $mahasiswa->nama ?? $mahasiswa->name }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 11px; tracking-wider: 1px;">Email / Username</small>
                        <span class="fs-5 fw-semibold text-secondary">{{ $mahasiswa->email ?? $mahasiswa->username }}</span>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <a href="{{ route('mahasiswa.profile.edit') }}" class="btn btn-primary px-4 py-2 shadow-sm rounded-2">
                            <i class="fas fa-edit me-1"></i> Edit Profil & Ganti Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection