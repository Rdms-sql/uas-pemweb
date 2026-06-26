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
        Schema::create('agens', function (Blueprint $table) {
            $table->id('id_agen');
            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->enum('level_agen', ['1','2','3']);
            $table->string('unit_kerja', 100)->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('foto_profil', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agens');
    }
};
