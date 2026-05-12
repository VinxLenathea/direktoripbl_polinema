<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TugasAkhir;
use App\Models\Kategori;

class TugasAkhirController extends Controller
{
    public function index()
    {
        $data = TugasAkhir::with('category')->get();
        $categories = Kategori::all();

        return view('tugas_akhir.index', compact('data', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|max:255',
            'abstrak'         => 'required',
            'tahun_lulus'     => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori_id'     => 'required|exists:kategori,id',
            'file_laporan'    => 'required|file|mimes:pdf|max:2048',
            'link_repository' => 'nullable|url',
            'demo_video'      => 'nullable|url',
        ]);

        $filePath = $request->file('file_laporan')->store('laporan', 'public');

        TugasAkhir::create([
            'judul'           => $request->judul,
            'abstrak'         => $request->abstrak,
            'tahun_lulus'     => $request->tahun_lulus,
            'kategori_id'     => $request->kategori_id,
            'file_laporan'    => $filePath,
            'link_repository' => $request->link_repository,
            'demo_video'      => $request->demo_video,
        ]);

        return redirect()->route('tugas_akhir.index')
            ->with('success', 'Tugas Akhir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tugasAkhir = TugasAkhir::findOrFail($id);

        return response()->json($tugasAkhir);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'           => 'required|max:255',
            'abstrak'         => 'required',
            'tahun_lulus'     => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori_id'     => 'required|exists:kategori,id',
            'file_laporan'    => 'nullable|file|mimes:pdf|max:2048',
            'link_repository' => 'nullable|url',
            'demo_video'      => 'nullable|url',
        ]);

        $tugasAkhir = TugasAkhir::findOrFail($id);

        if ($request->hasFile('file_laporan')) {

            if ($tugasAkhir->file_laporan) {
                Storage::disk('public')->delete($tugasAkhir->file_laporan);
            }

            $filePath = $request->file('file_laporan')->store('laporan', 'public');
            $tugasAkhir->file_laporan = $filePath;
        }

        $tugasAkhir->update([
            'judul'           => $request->judul,
            'abstrak'         => $request->abstrak,
            'tahun_lulus'     => $request->tahun_lulus,
            'kategori_id'     => $request->kategori_id,
            'link_repository' => $request->link_repository,
            'demo_video'      => $request->demo_video,
            'file_laporan'    => $tugasAkhir->file_laporan,
        ]);

        return redirect()->route('tugas_akhir.index')
            ->with('success', 'Tugas Akhir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tugasAkhir = TugasAkhir::findOrFail($id);

        if ($tugasAkhir->file_laporan) {
            Storage::disk('public')->delete($tugasAkhir->file_laporan);
        }

        $tugasAkhir->delete();

        return redirect()->route('tugas_akhir.index')
            ->with('success', 'Tugas Akhir berhasil dihapus.');
    }
}