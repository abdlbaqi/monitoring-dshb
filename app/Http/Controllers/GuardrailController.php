<?php

namespace App\Http\Controllers;

use App\Models\Guardrail;
use App\Models\Jalan;
use App\Models\MonitoringLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardrailController extends Controller
{
    public function index(Request $request)
    {
        $query = Guardrail::with('jalan');

        if ($request->has('jalan_id') && $request->jalan_id) {
            $query->where('jalan_id', $request->jalan_id);
        }

        $guardrails = $query->paginate(10);
        $jalans = Jalan::all();

        return view('admin.guardrail.index', compact('guardrails', 'jalans'));
    }

    public function create()
    {
        $this->authorize('admin-only');
        $jalans = Jalan::all();
        $tipeGuardrail = ['Baja', 'Beton', 'Kawat'];
        return view('admin.guardrail.create', compact('jalans', 'tipeGuardrail'));
    }

    public function store(Request $request)
    {
        $this->authorize('admin-only');
        
        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'tipe_guardrail' => 'required|string',
            'panjang_seharusnya' => 'required|numeric|min:0',
            'panjang_terpasang' => 'required|numeric|min:0',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required|numeric',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $guardrail = Guardrail::create($validated);

        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'guardrail',
            'perlengkapan_id' => $guardrail->id,
            'aksi' => 'create',
            'data_baru' => $guardrail->toArray(),
        ]);

        return redirect()->route('guardrail.index')->with('success', 'Data guardrail berhasil ditambahkan.');
    }

    public function show(Guardrail $guardrail)
    {
        return view('admin.guardrail.show', compact('guardrail'));
    }

    public function edit(Guardrail $guardrail)
    {
        $this->authorize('admin-only');
        $jalans = Jalan::all();
        $tipeGuardrail = ['Baja', 'Beton', 'Kawat'];
        return view('admin.guardrail.edit', compact('guardrail', 'jalans', 'tipeGuardrail'));
    }

    public function update(Request $request, Guardrail $guardrail)
    {
        $this->authorize('admin-only');
        
        $dataLama = $guardrail->toArray();
        
        $validated = $request->validate([
            'jalan_id' => 'required|exists:jalan,id',
            'tipe_guardrail' => 'required|string',
            'panjang_seharusnya' => 'required|numeric|min:0',
            'panjang_terpasang' => 'required|numeric|min:0',
            'km_awal' => 'required|numeric',
            'km_akhir' => 'required|numeric',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'tanggal_pemasangan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $guardrail->update($validated);

        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'guardrail',
            'perlengkapan_id' => $guardrail->id,
            'aksi' => 'update',
            'data_lama' => $dataLama,
            'data_baru' => $guardrail->toArray(),
        ]);

        return redirect()->route('guardrail.index')->with('success', 'Data guardrail berhasil diupdate.');
    }

    public function destroy(Guardrail $guardrail)
    {
        $this->authorize('admin-only');
        
        $dataLama = $guardrail->toArray();
        
        MonitoringLog::create([
            'user_id' => Auth::id(),
            'jenis_perlengkapan' => 'guardrail',
            'perlengkapan_id' => $guardrail->id,
            'aksi' => 'delete',
            'data_lama' => $dataLama,
        ]);

        $guardrail->delete();

        return redirect()->route('guardrail.index')->with('success', 'Data guardrail berhasil dihapus.');
    }
}