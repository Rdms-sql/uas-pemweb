<?php

use App\Http\Controllers\Admin\AgenController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\TiketController;
use App\Http\Controllers\Agen\AgenDashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\MahasiswaAuthController;
use App\Http\Controllers\Mahasiswa\MahasiswaDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/mahasiswa/login');
});

Route::get('/admin', function () {
    return redirect('/admin/login');
});

// BREEZE DEFAULT (jangan diubah)

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/mahasiswa/register', [MahasiswaAuthController::class, 'showRegister'])->name('mahasiswa.register');
Route::post('/mahasiswa/register', [MahasiswaAuthController::class, 'register']);
Route::get('/mahasiswa/login', [MahasiswaAuthController::class, 'showLogin'])->name('mahasiswa.login');
Route::post('/mahasiswa/login', [MahasiswaAuthController::class, 'login']);
Route::post('/mahasiswa/logout', [MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');


// ADMIN LOGIN (tanpa middleware)

Route::get('/admin/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


// ADMIN ROUTES (KAMU)

Route::prefix('admin')->middleware('auth.admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('agen', AgenController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('tiket', TiketController::class);
    Route::get('laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::resource('pengumuman', PengumumanController::class);
    Route::post('laporan', [LaporanController::class, 'store'])->name('admin.laporan.store');
});


// AGEN ROUTES (Rekan 2 & 3)

Route::prefix('agen')->middleware('auth.agen')->group(function () {

    Route::get('/dashboard',
        [AgenDashboardController::class,'index'])
        ->name('agen.dashboard');

    Route::get('/tiket/{id}',
        [AgenDashboardController::class,'show'])
        ->name('agen.tiket.show');

    Route::post('/tiket/{id}/proses',
        [AgenDashboardController::class,'proses'])
        ->name('agen.tiket.proses');

    Route::post('/tiket/{id}/selesai',
        [AgenDashboardController::class,'selesai'])
        ->name('agen.tiket.selesai');

    Route::post('/tiket/{id}/komentar',
        [AgenDashboardController::class, 'komentar'])
        ->name('agen.tiket.komentar');

});


// MAHASISWA ROUTES (Rekan 1)

Route::prefix('mahasiswa')->middleware('auth.mahasiswa')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/profile', [MahasiswaDashboardController::class, 'profile'])->name('mahasiswa.profile');
    Route::get('/profile/edit', [MahasiswaDashboardController::class, 'editProfile'])->name('mahasiswa.profile.edit');
    Route::post('/profile/edit', [MahasiswaDashboardController::class, 'updateProfile'])->name('mahasiswa.profile.update');
    Route::get('/tiket', [MahasiswaDashboardController::class, 'daftarTiket'])->name('mahasiswa.tiket');
    Route::get('/tiket/buat', [MahasiswaDashboardController::class, 'createTiket'])->name('mahasiswa.tiket.create');
    Route::post('/tiket/buat', [MahasiswaDashboardController::class, 'storeTiket'])->name('mahasiswa.tiket.store');
    Route::get('/tiket/{id}', [MahasiswaDashboardController::class, 'detailTiket'])->name('mahasiswa.tiket.show');
    Route::post('/tiket/{id}/rating', [MahasiswaDashboardController::class, 'storeRating'])->name('mahasiswa.tiket.rating');
});


require __DIR__.'/auth.php';