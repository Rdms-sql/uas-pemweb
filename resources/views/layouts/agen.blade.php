<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KampusCare - Agen')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
       body{
            background:#f4f6f9;
            font-family:'Segoe UI',sans-serif;
        }

        .navbar{
            box-shadow:0 2px 8px rgba(0,0,0,.08);
        }

        .navbar-brand{
            font-weight:700;
            font-size:20px;
        }

        .sidebar{
            position:fixed;
            top:56px;
            left:-260px;
            width:260px;
            height:calc(100vh - 56px);
            background:#343a40;
            transition:.3s;
            overflow-y:auto;
            z-index:999;
        }

        .sidebar.show{
            left:0;
        }

        .sidebar-header{
            padding:20px;
            border-bottom:1px solid rgba(255,255,255,.08);
        }

        .sidebar-header h6{
            color:#fff;
            margin-bottom:3px;
        }

        .sidebar-header small{
            color:#adb5bd;
        }

        .sidebar-title{
            color:#ced4da;
            font-size:12px;
            letter-spacing:1px;
            padding:18px 20px 8px;
            text-transform:uppercase;
        }

        .sidebar .nav-link{
            color:#ced4da;
            padding:12px 20px;
            transition:.2s;
            border-left:3px solid transparent;
        }

        .sidebar .nav-link:hover{
            color:white;
            background:#495057;
            border-left:3px solid #0d6efd;
        }

        .sidebar .nav-link.active{
            color:white;
            background:#0d6efd;
            border-left:3px solid white;
        }

        .sidebar i{
            width:22px;
        }

        .overlay{
            position:fixed;
            top:56px;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.4);
            display:none;
            z-index:998;
        }

        .overlay.show{
            display:block;
        }

        .main-content{
            margin-top:56px;
            padding:25px;
        }

        .card{
            border:none;
            border-radius:14px;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
        }

        .card-header{
            background:white;
            border-bottom:1px solid #eee;
            font-weight:600;
        }

        .table thead{
            background:#f8f9fa;
        }

        .table td{
            vertical-align:middle;
        }

        .btn{
            border-radius:10px;
        }

        .alert{
            border:none;
            border-radius:12px;
        }
            </style>
            @yield('styles')
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid px-3">
        <button class="btn btn-outline-light btn-sm me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <a class="navbar-brand" href="{{ route('agen.dashboard') }}"><i class="fas fa-headset me-2"></i>
            KampusCare</a>

        <div class="ms-auto d-flex align-items-center gap-2">
            <span class="text-white user-info d-none d-md-block">
                {{ Auth::guard('agen')->user()->nama }}
            </span>
            <span class="badge bg-light text-dark user-info d-none d-md-block">
                Level {{ Auth::guard('agen')->user()->level_agen }}
            </span>
            <form method="POST" action="{{ route('agen.logout') }}" class="d-inline">
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

    <div class="sidebar-header">
        <h6>{{ Auth::guard('agen')->user()->nama }}</h6>

        <small>
            Level {{ Auth::guard('agen')->user()->level_agen }}
        </small>

        <br>

        <small>
            {{ Auth::guard('agen')->user()->unit_kerja ?? 'KampusCare' }}
        </small>

    </div>

    <div class="sidebar-title">
        Menu
    </div>

    <nav class="nav flex-column">

        <a href="{{ route('agen.dashboard') }}"
        class="nav-link {{ request()->is('agen/dashboard') ? 'active' : '' }}">

            <i class="fas fa-home"></i>

            Dashboard

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