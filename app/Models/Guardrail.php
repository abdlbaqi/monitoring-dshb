<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardrail extends Model
{
    use HasFactory;

    protected $table = 'guardrail';

    protected $fillable = [
        'jalan_id', 'tipe_guardrail', 'panjang_seharusnya', 
        'panjang_terpasang', 'km_awal', 'km_akhir', 'kondisi', 
        'tanggal_pemasangan', 'keterangan'
    ];

    protected $casts = [
        'panjang_seharusnya' => 'decimal:2',
        'panjang_terpasang' => 'decimal:2',
        'km_awal' => 'decimal:2',
        'km_akhir' => 'decimal:2',
        'tanggal_pemasangan' => 'date',
    ];

    public function jalan()
    {
        return $this->belongsTo(Jalan::class);
    }

    public function getPersentaseAttribute()
    {
        return $this->panjang_seharusnya > 0 ? 
            round(($this->panjang_terpasang / $this->panjang_seharusnya) * 100, 2) : 0;
    }
}
