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
        Schema::create('apill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalan_id')->constrained('jalan')->onDelete('cascade');
            $table->enum('jenis_apill', ['traffic_light', 'warning_light']);
            $table->string('lokasi_persimpangan');
            $table->integer('jumlah_seharusnya');
            $table->integer('jumlah_terpasang')->default(0);
            $table->decimal('km_posisi', 8, 2);
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->boolean('berfungsi')->default(true);
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
        Schema::dropIfExists('apill');
    }
};
