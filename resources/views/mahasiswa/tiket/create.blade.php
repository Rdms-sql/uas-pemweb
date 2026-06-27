@extends('layouts.mahasiswa')

@section('title', 'Buat Laporan - KampusCare')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"> Buat Laporan Baru</h5>
            </div>
            <div class="card-body">

                <div class="alert alert-info py-2" style="font-size:13px">
                     Ceritakan masalahmu sejelas mungkin.
                    Tim kami akan segera menangani laporanmu.
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/mahasiswa/tiket/buat">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Laporan</label>
                        <input type="text" name="judul" class="form-control"
                               value="{{ old('judul') }}" required
                               placeholder="cth: Nilai belum keluar padahal sudah ujian">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ceritakan Masalahmu</label>
                        <textarea name="deskripsi" class="form-control" rows="6"
                                  required placeholder="Jelaskan masalahmu secara detail. Semakin detail semakin cepat ditangani...">{{ old('deskripsi') }}</textarea>
                        <small class="text-muted">Minimal 20 karakter</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection