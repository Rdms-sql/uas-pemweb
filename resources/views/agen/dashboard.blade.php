<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Agen Level 3</title>

    <style>
        body{
            font-family: Arial;
            margin:40px;
            background:#f5f5f5;
        }

        .card{
            display:inline-block;
            width:220px;
            margin:10px;
            padding:20px;
            background:white;
            border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
        }

        table{
            width:100%;
            margin-top:30px;
            border-collapse:collapse;
            background:white;
        }

        th,td{
            padding:12px;
            border:1px solid #ddd;
        }

        th{
            background:#0d6efd;
            color:white;
        }
    </style>

</head>
<body>

<h1>Dashboard Agen Level 3</h1>

<div class="card">
    <h3>Total Tiket</h3>
    <h1>{{ $total }}</h1>
</div>

<div class="card">
    <h3>Baru</h3>
    <h1>{{ $pending }}</h1>
</div>

<div class="card">
    <h3>Diproses</h3>
    <h1>{{ $diproses }}</h1>
</div>

<div class="card">
    <h3>Selesai</h3>
    <h1>{{ $selesai }}</h1>
</div>

<h2>5 Tiket Terbaru Level 3</h2>

<table>

<tr>
    <th>ID</th>
    <th>Judul</th>
    <th>Status</th>
    <th>Prioritas</th>
    <th>Aksi</th>
</tr>

@forelse($tikets as $tiket)

<tr>
    <td>{{ $tiket->id_tiket }}</td>
    <td>{{ $tiket->judul }}</td>
    <td>{{ $tiket->status }}</td>
    <td>{{ ucfirst($tiket->prioritas) }}</td>

    <td>
        <a href="{{ route('agen.tiket.show', $tiket->id_tiket) }}">
            Detail
        </a>
    </td>
</tr>

@empty

<tr>
    <td colspan="5">
        Belum ada tiket Level 3.
    </td>
</tr>

@endforelse

</table>

</body>
</html>