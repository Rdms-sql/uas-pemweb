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
        Schema::create('lapoans', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_admin');
            $table->string('periode', 20);
            $table->integer('total_tiket')->default(0);
            $table->integer('total_tiket_urgent')->default(0);
            $table->integer('tiket_level1')->default(0);
            $table->integer('tiket_level2')->default(0);
            $table->integer('tiket_level3')->default(0);
            $table->float('rata_sla_jam')->default(0);
            $table->float('rata_rating')->default(0);
            $table->date('tanggal_buat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapoans');
    }
};
