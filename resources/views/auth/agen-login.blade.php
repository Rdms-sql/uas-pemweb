<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Agen | KampusCare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        *{
            font-family:'Segoe UI',sans-serif;
        }

        body{
            margin:0;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#f4f8fc;
        }

        .login-card{
            width:100%;
            max-width:430px;
            background:#fff;
            border-radius:18px;
            padding:45px;
            box-shadow:0 15px 40px rgba(0,0,0,.08);
            border:1px solid #eef2f7;
        }

        .logo{
            width:80px;
            height:80px;
            background:#eaf3ff;
            color:#0d6efd;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto;
            font-size:34px;
        }

        h2{
            font-weight:700;
            color:#0d6efd;
            margin-top:20px;
        }

        .subtitle{
            color:#6c757d;
            font-size:15px;
            margin-bottom:30px;
        }

        .form-label{
            font-weight:600;
            margin-bottom:8px;
        }

        .input-group-text{
            background:white;
            border-right:none;
        }

        .form-control{
            border-left:none;
            height:48px;
        }

        .form-control:focus{
            box-shadow:none;
            border-color:#86b7fe;
        }

        .input-group:focus-within{
            border-radius:.375rem;
            box-shadow:0 0 0 .25rem rgba(13,110,253,.15);
        }

        .btn-login{
            height:48px;
            font-weight:600;
            font-size:16px;
            border-radius:10px;
        }

        .footer{
            margin-top:25px;
            color:#888;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="text-center">

        <div class="logo">
            <i class="fas fa-headset"></i>
        </div>

        <h2>KampusCare</h2>

        <p class="subtitle">
            Panel Login Agen
        </p>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('agen.login') }}">
        @csrf

        <div class="mb-3">

            <label class="form-label">
                Email
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required>

            </div>

        </div>

        <div class="mb-3">

            <label class="form-label">
                Password
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required>

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    onclick="togglePassword()">

                    <i class="fas fa-eye" id="eyeIcon"></i>

                </button>

            </div>

        </div>

        <div class="form-check mb-4">

            <input
                type="checkbox"
                class="form-check-input"
                id="remember"
                name="remember">

            <label class="form-check-label" for="remember">
                Ingat saya
            </label>

        </div>

        <button class="btn btn-primary w-100 btn-login">

            <i class="fas fa-right-to-bracket me-2"></i>

            Login

        </button>

    </form>

    <div class="text-center footer">

        © {{ date('Y') }} KampusCare

        <br>

        Universitas Pembangunan Jaya

    </div>

</div>

<script>

function togglePassword(){

    let password=document.getElementById("password");
    let eye=document.getElementById("eyeIcon");

    if(password.type==="password"){

        password.type="text";

        eye.classList.remove("fa-eye");

        eye.classList.add("fa-eye-slash");

    }else{

        password.type="password";

        eye.classList.remove("fa-eye-slash");

        eye.classList.add("fa-eye");

    }

}

</script>

</body>
</html>