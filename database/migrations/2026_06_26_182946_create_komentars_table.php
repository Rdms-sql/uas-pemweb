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
        Schema::create('komentars', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->foreignId('id_tiket')->constrained('tikets', 'id_tiket');
            $table->enum('pengirim_tipe', ['mahasiswa','agen','admin']);
            $table->unsignedBigInteger('id_pengirim');
            $table->text('pesan');
            $table->string('lampiran', 255)->nullable();
            $table->datetime('waktu_kirim');
            $table->boolean('is_internal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentars');
    }
};
