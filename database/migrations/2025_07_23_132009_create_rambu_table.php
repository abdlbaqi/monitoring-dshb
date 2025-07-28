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
         Schema::create('rambu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalan_id')->constrained('jalan')->onDelete('cascade');
            $table->string('jenis_rambu'); // Peringatan, Larangan, Perintah, Petunjuk
            $table->string('kode_rambu');
            $table->string('nama_rambu');
            $table->integer('jumlah_seharusnya');
            $table->integer('jumlah_terpasang')->default(0);
            $table->decimal('km_posisi', 8, 2)->nullable();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->date('tanggal_pemasangan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rambu');
    }
};
