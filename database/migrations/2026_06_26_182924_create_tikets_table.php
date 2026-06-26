<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->id('id_tiket');
            $table->foreignId('id_mahasiswa')->constrained('mahasiswas', 'id_mahasiswa');
            $table->foreignId('id_agen')->nullable()->constrained('agens', 'id_agen')->nullOnDelete();
            $table->foreignId('id_kategori')->constrained('kategoris', 'id_kategori');
            $table->string('judul', 200);
            $table->text('deskripsi');
            $table->boolean('is_urgent')->default(false);
            $table->text('alasan_urgent')->nullable();
            $table->enum('prioritas', ['rendah','sedang','tinggi'])->default('rendah');
            $table->enum('level_saat_ini', ['1','2','3'])->default('1');
            $table->enum('status', [
                'baru','menunggu_penugasan','diproses','menunggu_info',
                'dieskalasi_l2','dieskalasi_l3','ditangguhkan',
                'selesai','ditutup','dibatalkan'
            ])->default('baru');
            $table->string('lampiran', 255)->nullable();
            $table->datetime('sla_deadline')->nullable();
            $table->integer('rating')->nullable();
            $table->text('ulasan')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
