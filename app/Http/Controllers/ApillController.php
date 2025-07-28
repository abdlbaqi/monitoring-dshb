<?php

namespace App\Http\Controllers;

use App\Models\Apill;
use App\Models\Jalan;
use App\Models\MonitoringLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApillController extends Controller
{
    public function index(Request $request)
    {
        $query = Apill::with('jalan');

        if ($request->has('jalan_id') && $request->jalan_id) {
            $query->where('jalan_id', $request->jalan_id);
        }

        if ($request->has('jenis_apill') && $request->jenis_apill) {
            $query->where('jenis_apill', $request->jenis_apill);
        }

        $apills = $query->paginate(10);
        $jalans = Jalan::all();

        return view('apill.index', compact('apills', 'jalans'));
    }

    public function create()
    {
        $this->authorize('admin-only');
        $jalans = Jalan::all();
        return view('apill.create', compact('jalans'));
    }

    public function store(Request $request)
    {
        $this->authorize('admin-only');
        
        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'jenis_apill' => 'required|in:traffic_light,warning_light',
            'lokasi_persimpangan' => 'required|string',
            'jumlah_seharusnya' => 'required|integer|min:0',
            'jumlah_terpasang' => 'required|integer|min:0',
            'km_posisi' => 'required|numeric',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'berfungsi' => 'required|boolean',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $apill = Apill::create($validated);

        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'apill',
            'perlengkapan_id' => $apill->id,
            'aksi' => 'create',
            'data_baru' => $apill->toArray(),
        ]);

        return redirect()->route('apill.index')->with('success', 'Data APILL berhasil ditambahkan.');
    }

    public function show(Apill $apill)
    {
        return view('apill.show', compact('apill'));
    }

    public function edit(Apill $apill)
    {
        $this->authorize('admin-only');
        $jalans = Jalan::all();
        return view('apill.edit', compact('apill', 'jalans'));
    }

    public function update(Request $request, Apill $apill)
    {
        $this->authorize('admin-only');
        
        $dataLama = $apill->toArray();
        
        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'jenis_apill' => 'required|in:traffic_light,warning_light',
            'lokasi_persimpangan' => 'required|string',
            'jumlah_seharusnya' => 'required|integer|min:0',
            'jumlah_terpasang' => 'required|integer|min:0',
            'km_posisi' => 'required|numeric',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'berfungsi' => 'required|boolean',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $apill->update($validated);

        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'apill',
            'perlengkapan_id' => $apill->id,
            'aksi' => 'update',
            'data_lama' => $dataLama,
            'data_baru' => $apill->toArray(),
        ]);

        return redirect()->route('apill.index')->with('success', 'Data APILL berhasil diupdate.');
    }

    public function destroy(Apill $apill)
    {
        $this->authorize('admin-only');
        
        $dataLama = $apill->toArray();
        
        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'apill',
            'perlengkapan_id' => $apill->id,
            'aksi' => 'delete',
            'data_lama' => $dataLama,
        ]);

        $apill->delete();

        return redirect()->route('apill.index')->with('success', 'Data APILL berhasil dihapus.');
    }
}