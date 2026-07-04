<!DOCTYPE html>
<html>
<head>

    <title>Detail Tiket</title>

    <style>

        body{
            font-family:Arial;
            margin:40px;
            background:#f5f5f5;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
        }

        p{
            margin:12px 0;
        }

        a{
            text-decoration:none;
            color:white;
            background:#0d6efd;
            padding:10px 18px;
            border-radius:6px;
        }

    </style>

</head>

<body>

@if(session('success'))

<div style="
padding:15px;
background:#d4edda;
color:#155724;
margin-bottom:20px;
border-radius:6px;
">

{{ session('success') }}

</div>

@endif

<form action="{{ route('agen.tiket.proses', $tiket->id_tiket) }}"
      method="POST">

    @csrf

    <button type="submit">
        Proses Tiket
    </button>

</form>

<br>

@if($tiket->status == 'baru')
<form action="{{ route('agen.tiket.proses', $tiket->id_tiket) }}" method="POST" style="margin-top:20px;">
    @csrf
    <button type="submit">Proses Tiket</button>
</form>
@endif

@if($tiket->status == 'diproses')
<form action="{{ route('agen.tiket.selesai', $tiket->id_tiket) }}" method="POST" style="margin-top:20px;">
    @csrf
    <button type="submit">Selesaikan Tiket</button>
</form>
@endif

<a href="{{ route('agen.dashboard') }}">
    ← Kembali
</a>

<hr>

<h3>Tambah Komentar</h3>

<form action="{{ route('agen.tiket.komentar', $tiket->id_tiket) }}" method="POST">
    @csrf

    <textarea
        name="pesan"
        rows="4"
        style="width:100%;"
        placeholder="Masukkan komentar..."
        required></textarea>

    <br><br>

    <button type="submit">
        Kirim Komentar
    </button>
</form>
<hr>

<h3>Riwayat Komentar</h3>

@forelse($komentars as $komentar)

<div style="border:1px solid #ddd;padding:15px;margin-bottom:10px;border-radius:8px;">

    <b>{{ ucfirst($komentar->pengirim_tipe) }}</b>

    <br><br>

    {{ $komentar->pesan }}

    <br><br>

    <small>
        {{ $komentar->waktu_kirim }}
    </small>

</div>

@empty

<p>Belum ada komentar.</p>

@endforelse

<br><br>

<div class="card">

<h2>{{ $tiket->judul }}</h2>

<hr>

<p><b>ID Tiket :</b> {{ $tiket->id_tiket }}</p>

<p><b>Mahasiswa :</b> {{ $tiket->mahasiswa->nama }}</p>

<p><b>Kategori :</b> {{ $tiket->kategori->nama_kategori }}</p>

<p><b>Status :</b> {{ $tiket->status }}</p>

<p><b>Prioritas :</b> {{ ucfirst($tiket->prioritas) }}</p>

<p><b>Level :</b> {{ $tiket->level_saat_ini }}</p>

<p><b>Deskripsi :</b></p>

<p>{{ $tiket->deskripsi }}</p>

@if($tiket->lampiran)

<p>

<b>Lampiran :</b>

{{ $tiket->lampiran }}

</p>

@endif

</div>

</body>
</html>