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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id('id_notif');
            $table->enum('penerima_tipe', ['mahasiswa','agen','admin']);
            $table->unsignedBigInteger('id_penerima');
            $table->foreignId('id_tiket')->nullable()->constrained('tikets', 'id_tiket')->nullOnDelete();
            $table->string('judul_notif', 200);
            $table->text('pesan');
            $table->enum('tipe_notif', [
                'status_berubah','komentar_baru','tiket_urgent',
                'eskalasi','sla_warning','sistem'
            ]);
            $table->boolean('is_read')->default(false);
            $table->datetime('waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
