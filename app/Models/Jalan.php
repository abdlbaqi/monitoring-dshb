<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    use HasFactory;

    protected $table = 'jalan';
    
    protected $fillable = [
        'kode_jalan', 'nama_jalan', 'kelas_jalan', 'panjang_km', 'lokasi', 'keterangan'
    ];

    protected $casts = [
        'panjang_km' => 'decimal:2',
    ];

    public function rambu()
    {
        return $this->hasMany(Rambu::class);
    }

    public function marka()
    {
        return $this->hasMany(Marka::class);
    }

    public function guardrail()
    {
        return $this->hasMany(Guardrail::class);
    }

    public function apill()
    {
        return $this->hasMany(Apill::class);
    }

    // Hitung persentase kinerja untuk semua perlengkapan
    public function getPersentaseKinerjaAttribute()
    {
        $rambuPersentase = $this->getPersentaseRambu();
        $markaPersentase = $this->getPersentaseMarka();
        $guardrailPersentase = $this->getPersentaseGuardrail();
        $apillPersentase = $this->getPersentaseApill();

        return [
            'rambu' => $rambuPersentase,
            'marka' => $markaPersentase,
            'guardrail' => $guardrailPersentase,
            'apill' => $apillPersentase,
            'rata_rata' => ($rambuPersentase + $markaPersentase + $guardrailPersentase + $apillPersentase) / 4
        ];
    }

    public function getPersentaseRambu()
    {
        $totalSeharusnya = $this->rambu->sum('jumlah_seharusnya');
        $totalTerpasang = $this->rambu->sum('jumlah_terpasang');
        return $totalSeharusnya > 0 ? round(($totalTerpasang / $totalSeharusnya) * 100, 2) : 0;
    }

    public function getPersentaseMarka()
    {
        $totalSeharusnya = $this->marka->sum('panjang_seharusnya');
        $totalTerpasang = $this->marka->sum('panjang_terpasang');
        return $totalSeharusnya > 0 ? round(($totalTerpasang / $totalSeharusnya) * 100, 2) : 0;
    }

    public function getPersentaseGuardrail()
    {
        $totalSeharusnya = $this->guardrail->sum('panjang_seharusnya');
        $totalTerpasang = $this->guardrail->sum('panjang_terpasang');
        return $totalSeharusnya > 0 ? round(($totalTerpasang / $totalSeharusnya) * 100, 2) : 0;
    }

    public function getPersentaseApill()
    {
        $totalSeharusnya = $this->apill->sum('jumlah_seharusnya');
        $totalTerpasang = $this->apill->sum('jumlah_terpasang');
        return $totalSeharusnya > 0 ? round(($totalTerpasang / $totalSeharusnya) * 100, 2) : 0;
    }
}