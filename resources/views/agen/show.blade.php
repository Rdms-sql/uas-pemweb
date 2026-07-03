<!DOCTYPE html>
<html>
<head>
    <title>Detail Tiket</title>

    <style>
        body{
            font-family:Arial;
            background:#f5f5f5;
            margin:40px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            max-width:800px;
        }

        table{
            width:100%;
        }

        td{
            padding:10px;
            border-bottom:1px solid #ddd;
        }

        h2{
            margin-top:0;
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
background:#d4edda;
padding:15px;
margin-bottom:20px;
border-radius:6px;
color:#155724;
">
    {{ session('success') }}
</div>
@endif

<div class="card">

<h2>Detail Tiket</h2>

<table>

<tr>
    <td width="220"><b>ID Tiket</b></td>
    <td>{{ $tiket->id_tiket }}</td>
</tr>

<tr>
    <td><b>Mahasiswa</b></td>
    <td>{{ $tiket->mahasiswa->nama ?? '-' }}</td>
</tr>

<tr>
    <td><b>Kategori</b></td>
    <td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td>
</tr>

<tr>
    <td><b>Judul</b></td>
    <td>{{ $tiket->judul }}</td>
</tr>

<tr>
    <td><b>Deskripsi</b></td>
    <td>{{ $tiket->deskripsi }}</td>
</tr>

<tr>
    <td><b>Status</b></td>
    <td>{{ ucfirst($tiket->status) }}</td>
</tr>

<tr>
    <td><b>Prioritas</b></td>
    <td>{{ ucfirst($tiket->prioritas) }}</td>
</tr>

<tr>
    <td><b>Urgent</b></td>
    <td>{{ $tiket->is_urgent ? 'Ya' : 'Tidak' }}</td>
</tr>

<tr>
    <td><b>Lampiran</b></td>
    <td>
        @if($tiket->lampiran)
            <a href="{{ asset('storage/'.$tiket->lampiran) }}" target="_blank">
                Lihat Lampiran
            </a>
        @else
            Tidak ada
        @endif
    </td>
</tr>

</table>

<br>

@if($tiket->status == 'baru')

<form action="{{ route('agen.tiket.proses',$tiket->id_tiket) }}" method="POST">
    @csrf
    <button type="submit">
        Proses Tiket
    </button>
</form>

<br>

@endif


@if($tiket->status == 'diproses')

<form action="{{ route('agen.tiket.selesai',$tiket->id_tiket) }}" method="POST">
    @csrf
    <button type="submit">
        Selesaikan Tiket
    </button>
</form>

<br>

@endif


<a href="{{ route('agen.dashboard') }}">
    ← Kembali
</a>

</div>

</body>
</html>