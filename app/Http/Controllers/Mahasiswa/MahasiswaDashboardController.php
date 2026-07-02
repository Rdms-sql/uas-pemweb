<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\Kategori;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaDashboardController extends Controller
{
    // Dashboard utama
    public function index()
    {
        $mahasiswa   = Auth::guard('mahasiswa')->user();
        $tikets      = Tiket::where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                            ->latest()->take(5)->get();
        $pengumumans = Pengumuman::where('is_active', true)->latest()->take(3)->get();

        return view('mahasiswa.dashboard', compact('mahasiswa', 'tikets', 'pengumumans'));
    }

    // Form buat laporan
    public function createTiket()
    {
        return view('mahasiswa.tiket.create');
    }

    // Simpan laporan + deteksi urgent otomatis
        public function storeTiket(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'required|string|min:20',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();

        $isUrgent = $this->deteksiUrgent($request->judul, $request->deskripsi);

        $kategori = Kategori::where('is_active', true)->first();

        if (!$kategori) {
            return back()->withErrors([
                'judul' => 'Sistem belum siap karena data Kategori di database masih kosong. Hubungi administrator/admin kelompok untuk isi tabel kategoris!'
            ]);
        }

        $slaJam      = $isUrgent ? $kategori->sla_jam_urgent : $kategori->sla_jam_normal;
        $slaDeadline = now()->addHours($slaJam);
        
        Tiket::create([
            'id_mahasiswa'   => $mahasiswa->id_mahasiswa,
            'id_agen'        => null,
            'id_kategori'    => $kategori->id_kategori,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'is_urgent'      => $isUrgent,
            'alasan_urgent'  => $isUrgent ? 'Terdeteksi otomatis oleh sistem' : null,
            'prioritas'      => $isUrgent ? 'tinggi' : 'rendah',
            'level_saat_ini' => $kategori->level_agen_default,
            'status'         => 'baru',
            'sla_deadline'   => $slaDeadline,
        ]);

        return redirect('/mahasiswa/tiket')
        ->with('success', 'Laporan berhasil dikirim! Tim kami akan segera menangani.');

    }

    public function storeRating(Request $request, $id)
    {
        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $tiket = Tiket::findOrFail($id);

        $tiket->update([
            'rating'   => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect('/mahasiswa/tiket')
            ->with('success', 'Terima kasih! Penilaian kamu berhasil disimpan.');
    }

    // Daftar tiket mahasiswa + Fitur Cari & Filter Status
    public function daftarTiket(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        $query = Tiket::with('kategori')->where('id_mahasiswa', $mahasiswa->id_mahasiswa);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', '%' . $search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tikets = $query->latest()->paginate(10)->withQueryString();

        return view('mahasiswa.tiket.index', compact('tikets'));
    }
    // Detail tiket
    public function detailTiket(int $id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $tiket     = Tiket::with(['kategori', 'komentars'])
                          ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                          ->findOrFail($id);

        return view('mahasiswa.tiket.show', compact('tiket'));
    }

    // HALAMAN PROFIL MAHASISWA
    public function profile()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        return view('mahasiswa.profile', compact('mahasiswa'));
    }

    public function editProfile()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.edit', compact('mahasiswa'));
    }


    public function updateProfile(Request $request)
{
    $mahasiswa = Auth::guard('mahasiswa')->user();

    // Validasi input
    $request->validate([
        'nama'     => 'required|string|max:100',
        'email'    => 'required|email|max:100|unique:users,email,' . $mahasiswa->id,
        'password' => 'nullable|string|min:6|confirmed', 
    ]);

    $dataUpdate = [
        'nama'  => $request->nama,
        'email' => $request->email,
    ];

    if ($request->filled('password')) {
        $dataUpdate['password'] = bcrypt($request->password);
    }

    $mahasiswa->update($dataUpdate);

    return redirect()->route('mahasiswa.profile.edit')->with('success', 'Profil dan password berhasil diperbarui!');
}


    // DETEKSI URGENT OTOMATIS
    private function deteksiUrgent(string $judul, string $deskripsi): bool
    {
        $teks = strtolower($judul . ' ' . $deskripsi);

        $keywordUrgent = [
            // Waktu mendesak
            'segera', 'urgent', 'darurat', 'mendesak', 'cepat', 'batas waktu',
            'deadline', 'besok', 'hari ini', 'sekarang', 'malam ini',
            // Akademik kritis
            'wisuda', 'sidang', 'ujian akhir', 'uas', 'uts', 'yudisium',
            'ijazah', 'transkrip', 'kelulusan', 'tidak bisa kuliah',
            // Masalah serius
            'tidak bisa login', 'akun terkunci', 'data hilang', 'salah nilai',
            'nilai tidak keluar', 'krs bermasalah', 'tidak bisa daftar',
            'pembayaran gagal', 'beasiswa', 'sanksi', 'drop out', 'do',
        ];

        foreach ($keywordUrgent as $keyword) {
            if (str_contains($teks, $keyword)) {
                return true;
            }
        }

        return false;
    }
}