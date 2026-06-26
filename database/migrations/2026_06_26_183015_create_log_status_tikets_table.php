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
        Schema::create('log_status_tikets', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_tiket')->constrained('tikets', 'id_tiket');
            $table->string('status_lama', 50)->nullable();
            $table->string('status_baru', 50);
            $table->enum('level_lama', ['1','2','3'])->nullable();
            $table->enum('level_baru', ['1','2','3'])->nullable();
            $table->enum('changed_by_tipe', ['mahasiswa','agen','admin','sistem']);
            $table->unsignedBigInteger('changed_by_id');
            $table->text('catatan')->nullable();
            $table->datetime('waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_status_tikets');
    }
};
