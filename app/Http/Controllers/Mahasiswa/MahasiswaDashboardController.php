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
            'judul'    => 'required|string|max:200',
            'deskripsi'=> 'required|string|min:20',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Deteksi urgent otomatis
        $isUrgent = $this->deteksiUrgent($request->judul, $request->deskripsi);

        // Ambil kategori default (pertama yang aktif)
        $kategori = Kategori::where('is_active', true)->first();

        
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
            
            if (!$kategori) {
                return back()->withErrors([
                    'judul' => 'Sistem belum siap, hubungi administrator.'
                ]);
            }

            return redirect('/mahasiswa/tiket')
               ->with('success', ' Laporan berhasil dikirim! Tim kami akan segera menangani.');
    }

    // Daftar tiket mahasiswa
    public function daftarTiket()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $tikets    = Tiket::with('kategori')
                          ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
                          ->latest()->paginate(10);

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