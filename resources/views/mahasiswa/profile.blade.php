@extends('layouts.mahasiswa') {{-- Ini mengikuti template dashboard kelompokmu --}}

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Profil Mahasiswa</h2>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-500 uppercase">Nama Lengkap</label>
                {{-- Menampilkan nama dari database --}}
                <p class="text-lg font-medium text-gray-900 mt-1">{{ $mahasiswa->nama ?? $mahasiswa->name }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-500 uppercase">ID / Email / Username</label>
                {{-- Menampilkan email atau id_mahasiswa --}}
                <p class="text-lg font-medium text-gray-900 mt-1">{{ $mahasiswa->email ?? $mahasiswa->username }}</p>
            </div>
        </div>

        {{-- Tombol ini dipersiapkan untuk Step 2 (Edit & Ganti Password) nanti --}}
        <div class="mt-8">
            <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded shadow transition">
                Edit Profil & Ganti Password
            </a>
        </div>
    </div>
</div>
@endsection