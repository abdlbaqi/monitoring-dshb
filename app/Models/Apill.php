<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apill extends Model
{
    use HasFactory;

    protected $table = 'apill';

    protected $fillable = [
        'jalan_id', 'jenis_apill', 'lokasi_persimpangan', 
        'jumlah_seharusnya', 'jumlah_terpasang', 'km_posisi', 
        'kondisi', 'berfungsi', 'tanggal_pemasangan', 'keterangan'
    ];

    protected $casts = [
        'km_posisi' => 'decimal:2',
        'berfungsi' => 'boolean',
        'tanggal_pemasangan' => 'date',
    ];

    public function jalan()
    {
        return $this->belongsTo(Jalan::class);
    }

    public function getPersentaseAttribute()
    {
        return $this->jumlah_seharusnya > 0 ? 
            round(($this->jumlah_terpasang / $this->jumlah_seharusnya) * 100, 2) : 0;
    }
}

