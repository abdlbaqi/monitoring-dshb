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
        Schema::create('guardrail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalan_id')->constrained('jalan')->onDelete('cascade');
            $table->string('tipe_guardrail'); // Baja, Beton, Kawat
            $table->decimal('panjang_seharusnya', 10, 2);
            $table->decimal('panjang_terpasang', 10, 2)->default(0);
            $table->decimal('km_awal', 8, 2);
            $table->decimal('km_akhir', 8, 2);
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
        Schema::dropIfExists('guardrail');
    }
};
