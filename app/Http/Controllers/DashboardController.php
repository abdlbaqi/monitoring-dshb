<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\Rambu;
use App\Models\Marka;
use App\Models\Guardrail;
use App\Models\Apill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalJalan = Jalan::count();
        $totalRambu = Rambu::sum('jumlah_terpasang');
        $totalMarka = Marka::sum('panjang_terpasang');
        $totalGuardrail = Guardrail::sum('panjang_terpasang');
        $totalApill = Apill::sum('jumlah_terpasang');

        // Persentase kinerja keseluruhan
        $rambuSeharusnya = Rambu::sum('jumlah_seharusnya');
        $rambuTerpasang = Rambu::sum('jumlah_terpasang');
        $persentaseRambu = $rambuSeharusnya > 0 ? round(($rambuTerpasang / $rambuSeharusnya) * 100, 2) : 0;

        $markaSeharusnya = Marka::sum('panjang_seharusnya');
        $markaTerpasang = Marka::sum('panjang_terpasang');
        $persentaseMarka = $markaSeharusnya > 0 ? round(($markaTerpasang / $markaSeharusnya) * 100, 2) : 0;

        $guardrailSeharusnya = Guardrail::sum('panjang_seharusnya');
        $guardrailTerpasang = Guardrail::sum('panjang_terpasang');
        $persentaseGuardrail = $guardrailSeharusnya > 0 ? round(($guardrailTerpasang / $guardrailSeharusnya) * 100, 2) : 0;

        $apillSeharusnya = Apill::sum('jumlah_seharusnya');
        $apillTerpasang = Apill::sum('jumlah_terpasang');
        $persentaseApill = $apillSeharusnya > 0 ? round(($apillTerpasang / $apillSeharusnya) * 100, 2) : 0;

        // Data untuk chart
        $jalans = Jalan::with(['rambu', 'marka', 'guardrail', 'apill'])->get();
        $chartData = [];
        foreach ($jalans as $jalan) {
            $kinerja = $jalan->persentase_kinerja;
            $chartData[] = [
                'jalan' => $jalan->nama_jalan,
                'rambu' => $kinerja['rambu'],
                'marka' => $kinerja['marka'],
                'guardrail' => $kinerja['guardrail'],
                'apill' => $kinerja['apill'],
            ];
        }

        return view('admin.dashboard', compact(
            'totalJalan', 'totalRambu', 'totalMarka', 'totalGuardrail', 'totalApill',
            'persentaseRambu', 'persentaseMarka', 'persentaseGuardrail', 'persentaseApill',
            'chartData'
        ));
    }
}
