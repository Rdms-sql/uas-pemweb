<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - KampusCare</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h4 class="text-center mb-1">🎓 KampusCare</h4>
                    <p class="text-center text-muted mb-2">Daftar Akun Mahasiswa</p>

                    {{-- Info NIM otomatis --}}
                    {{-- <div class="alert alert-info py-2 text-center" style="font-size:13px">
                        🎫 NIM akan dibuat otomatis oleh sistem setelah mendaftar
                    </div> --}}

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/mahasiswa/register">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control"
                                   value="{{ old('nama') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Kampus</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Program Studi</label>
                            <input type="text" name="program_studi" class="form-control"
                                   value="{{ old('program_studi') }}"
                                   placeholder="cth: Teknik Informatika">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control"
                                   value="{{ old('no_telepon') }}"
                                   placeholder="cth: 08123456789">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>

                    <hr>
                    <p class="text-center mb-0">
                        Sudah punya akun?
                        <a href="/mahasiswa/login">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>