<?php

namespace App\Http\Controllers;

use App\Models\Rambu;
use App\Models\Jalan;
use App\Models\MonitoringLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RambuController extends Controller
{
    public function index(Request $request)
    {
        $query = Rambu::with('jalan');

        if ($request->has('jalan_id') && $request->jalan_id) {
            $query->where('jalan_id', $request->jalan_id);
        }

        if ($request->has('jenis_rambu') && $request->jenis_rambu) {
            $query->where('jenis_rambu', $request->jenis_rambu);
        }

        $rambus = $query->paginate(10);
        $jalans = Jalan::all();
        $jenisRambu = ['Peringatan', 'Larangan', 'Perintah', 'Petunjuk'];

        return view('admin.rambu.index', compact('rambus', 'jalans', 'jenisRambu'));
    }

    public function create()
    {

        $jalans = Jalan::all();
        $jenisRambu = ['Peringatan', 'Larangan', 'Perintah', 'Petunjuk'];
        return view('admin.rambu.create', compact('jalans', 'jenisRambu'));
    }

    public function store(Request $request)
    {

        
        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'jenis_rambu' => 'required|string',
            'kode_rambu' => 'required|string',
            'nama_rambu' => 'required|string',
            'jumlah_seharusnya' => 'required|integer|min:0',
            'jumlah_terpasang' => 'required|integer|min:0',
            'km_posisi' => 'nullable|numeric',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $rambu = Rambu::create($validated);

        // Log aktivitas
        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'rambu',
            'perlengkapan_id' => $rambu->id,
            'aksi' => 'create',
            'data_baru' => $rambu->toArray(),
        ]);

        return redirect()->route('rambu.index')->with('success', 'Data rambu berhasil ditambahkan.');
    }

    public function show(Rambu $rambu)
    {
        return view('rambu.show', compact('rambu'));
    }

    public function edit(Rambu $rambu)
    {
        $this->authorize('admin-only');
        $jalans = Jalan::all();
        $jenisRambu = ['Peringatan', 'Larangan', 'Perintah', 'Petunjuk'];
        return view('rambu.edit', compact('rambu', 'jalans', 'jenisRambu'));
    }

    public function update(Request $request, Rambu $rambu)
    {
        $this->authorize('admin-only');
        
        $dataLama = $rambu->toArray();
        
        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'jenis_rambu' => 'required|string',
            'kode_rambu' => 'required|string',
            'nama_rambu' => 'required|string',
            'jumlah_seharusnya' => 'required|integer|min:0',
            'jumlah_terpasang' => 'required|integer|min:0',
            'km_posisi' => 'nullable|numeric',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $rambu->update($validated);

        // Log aktivitas
        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'rambu',
            'perlengkapan_id' => $rambu->id,
            'aksi' => 'update',
            'data_lama' => $dataLama,
            'data_baru' => $rambu->toArray(),
        ]);

        return redirect()->route('rambu.index')->with('success', 'Data rambu berhasil diupdate.');
    }

    public function destroy(Rambu $rambu)
    {
        $this->authorize('admin-only');
        
        $dataLama = $rambu->toArray();
        
        // Log aktivitas
        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'rambu',
            'perlengkapan_id' => $rambu->id,
            'aksi' => 'delete',
            'data_lama' => $dataLama,
        ]);

        $rambu->delete();

        return redirect()->route('rambu.index')->with('success', 'Data rambu berhasil dihapus.');
    }
}
