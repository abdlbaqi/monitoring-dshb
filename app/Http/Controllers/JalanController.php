<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use Illuminate\Http\Request;

class JalanController extends Controller
{
    public function index()
    {
        $jalans = Jalan::withCount(['rambu', 'marka', 'guardrail', 'apill'])->paginate(10);
        return view('admin.jalan.index', compact('jalans'));
    }

    public function create()
    {
        return view('admin.jalan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_jalan' => 'required|string|unique:jalan,kode_jalan',
            'nama_jalan' => 'required|string',
            'kelas_jalan' => 'required|in:Arteri,Kolektor,Lokal',
            'panjang_km' => 'required|numeric|min:0',
            'lokasi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Jalan::create($validated);

        return redirect()->route('jalan.index')->with('success', 'Data jalan berhasil ditambahkan.');
    }

    public function show(Jalan $jalan)
    {
        $jalan->load(['rambu', 'marka', 'guardrail', 'apill']);
        return view('jalan.show', compact('jalan'));
    }

    public function edit(Jalan $jalan)
    {
        return view('admin.jalan.edit', compact('jalan'));
    }

    public function update(Request $request, Jalan $jalan)
    {
        $validated = $request->validate([
            'kode_jalan' => 'required|string|unique:jalan,kode_jalan,' . $jalan->id,
            'nama_jalan' => 'required|string',
            'kelas_jalan' => 'required|in:Arteri,Kolektor,Lokal',
            'panjang_km' => 'required|numeric|min:0',
            'lokasi' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $jalan->update($validated);

        return redirect()->route('admin.jalan.index')->with('success', 'Data jalan berhasil diupdate.');
    }

    public function destroy(Jalan $jalan)
    {
        $jalan->delete();
        return redirect()->route('admin.jalan.index')->with('success', 'Data jalan berhasil dihapus.');
    }
}