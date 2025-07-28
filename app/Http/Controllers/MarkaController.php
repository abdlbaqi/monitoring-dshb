<?php

namespace App\Http\Controllers;

use App\Models\Marka;
use App\Models\Jalan;
use App\Models\MonitoringLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkaController extends Controller
{
    public function index(Request $request)
    {
        $query = Marka::with('jalan');

        if ($request->has('jalan_id') && $request->jalan_id) {
            $query->where('jalan_id', $request->jalan_id);
        }

        $markas = $query->paginate(10);
        $jalans = Jalan::all();

        return view('marka.index', compact('markas', 'jalans'));
    }

    public function create()
    {
        $this->authorize('admin-only');
        $jalans = Jalan::all();
        return view('marka.create', compact('jalans'));
    }

    public function store(Request $request)
    {
        $this->authorize('admin-only');
        
        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'jenis_marka' => 'required|string',
            'warna' => 'required|in:Putih,Kuning',
            'panjang_seharusnya' => 'required|numeric|min:0',
            'panjang_terpasang' => 'required|numeric|min:0',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required|numeric',
            'kondisi' => 'required|in:baik,pudar,hilang',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $marka = Marka::create($validated);

        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'marka',
            'perlengkapan_id' => $marka->id,
            'aksi' => 'create',
            'data_baru' => $marka->toArray(),
        ]);

        return redirect()->route('marka.index')->with('success', 'Data marka berhasil ditambahkan.');
    }

        public function show(Marka $marka)
    {
        return view('marka.show', compact('marka'));
    }

    public function edit(Marka $marka)
    {
        $this->authorize('admin-only');
        $jalans = Jalan::all();
        return view('marka.edit', compact('marka', 'jalans'));
    }

    public function update(Request $request, Marka $marka)
    {
        $this->authorize('admin-only');

        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'jenis_marka' => 'required|string',
            'warna' => 'required|in:Putih,Kuning',
            'panjang_seharusnya' => 'required|numeric|min:0',
            'panjang_terpasang' => 'required|numeric|min:0',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required|numeric',
            'kondisi' => 'required|in:baik,pudar,hilang',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $data_lama = $marka->toArray();
        $marka->update($validated);

        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'marka',
            'perlengkapan_id' => $marka->id,
            'aksi' => 'update',
            'data_lama' => $data_lama,
            'data_baru' => $marka->toArray(),
        ]);

        return redirect()->route('marka.index')->with('success', 'Data marka berhasil diperbarui.');
    }

    public function destroy(Marka $marka)
    {
        $this->authorize('admin-only');

        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'marka',
            'perlengkapan_id' => $marka->id,
            'aksi' => 'delete',
            'data_lama' => $marka->toArray(),
        ]);

        $marka->delete();

        return redirect()->route('marka.index')->with('success', 'Data marka berhasil dihapus.');
    }
}
