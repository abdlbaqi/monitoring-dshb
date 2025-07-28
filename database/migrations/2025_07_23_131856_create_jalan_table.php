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
         Schema::create('jalan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jalan')->unique();
            $table->string('nama_jalan');
            $table->string('kelas_jalan'); // Arteri, Kolektor, Lokal
            $table->decimal('panjang_km', 8, 2);
            $table->string('lokasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalan');
    }
};
