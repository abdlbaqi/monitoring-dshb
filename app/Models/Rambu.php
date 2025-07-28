<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rambu extends Model
{
    use HasFactory;

    protected $table = 'rambu';

    protected $fillable = [
        'jalan_id', 'jenis_rambu', 'kode_rambu', 'nama_rambu', 
        'jumlah_seharusnya', 'jumlah_terpasang', 'km_posisi', 
        'kondisi', 'tanggal_pemasangan', 'keterangan'
    ];

    protected $casts = [
        'km_posisi' => 'decimal:2',
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