<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KampusCare')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .navbar-brand { font-weight: 700; font-size: 1.3rem; }
        .sidebar {
            position: fixed; top: 56px; left: -250px;
            width: 250px; height: calc(100vh - 56px);
            background: #343a40; z-index: 999;
            transition: left 0.3s ease; overflow-y: auto;
        }
        .sidebar.show { left: 0; }
        .sidebar .nav-link {
            color: #adb5bd; padding: 12px 20px;
            border-bottom: 1px solid #495057;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff; background: #495057;
        }
        .sidebar .nav-link i { width: 20px; margin-right: 8px; }
        .overlay {
            display: none; position: fixed;
            top: 56px; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 998;
        }
        .overlay.show { display: block; }
        .main-content { padding: 20px 15px; }
        .user-info { font-size: 13px; }
    </style>
    @yield('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid px-3">

        {{-- Hamburger --}}
        <button class="btn btn-outline-light btn-sm me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <a class="navbar-brand" href="/mahasiswa/dashboard">🎓 KampusCare</a>

        <div class="ms-auto d-flex align-items-center gap-2">
            <span class="text-white user-info d-none d-md-block">
                {{ Auth::guard('mahasiswa')->user()->nama }}
            </span>
            <span class="badge bg-light text-dark user-info d-none d-md-block">
                NIM: {{ Auth::guard('mahasiswa')->user()->nim }}
            </span>
            <form method="POST" action="/mahasiswa/logout" class="d-inline">
                @csrf
                <button class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="d-none d-md-inline ms-1">Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- Overlay --}}
<div class="overlay" id="overlay"></div>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    {{-- Info User di Sidebar --}}
    <div class="p-3 border-bottom" style="background:#2c3136">
        <div class="text-white fw-bold">{{ Auth::guard('mahasiswa')->user()->nama }}</div>
        <div class="text-muted" style="font-size:12px">
            NIM: {{ Auth::guard('mahasiswa')->user()->nim }}
        </div>
        <div class="text-muted" style="font-size:12px">
            {{ Auth::guard('mahasiswa')->user()->program_studi ?? 'Mahasiswa' }}
        </div>
    </div>

    {{-- Menu --}}
    <nav class="nav flex-column mt-1">
        <a href="/mahasiswa/dashboard"
           class="nav-link {{ request()->is('mahasiswa/dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="/mahasiswa/tiket/buat"
           class="nav-link {{ request()->is('mahasiswa/tiket/buat') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Buat Laporan
        </a>
        <a href="/mahasiswa/tiket"
           class="nav-link {{ request()->is('mahasiswa/tiket') ? 'active' : '' }}">
            <i class="fas fa-list"></i> Laporan Saya
        </a>
        <a href="{{ route('mahasiswa.profile') }}"
           class="nav-link {{ request()->is('mahasiswa/profile*') ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> Profil Saya
        </a>
    </nav>
</div>

{{-- Main Content --}}
<div class="main-content" style="margin-top: 56px;">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggle   = document.getElementById('sidebarToggle');
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('overlay');

    toggle.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
</script>
@yield('scripts')
</body>
</html>