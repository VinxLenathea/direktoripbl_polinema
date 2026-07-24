<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\TugasAkhir;
use App\Models\Kategori;
use App\Models\Mahasiswa;

class TugasAkhirController extends Controller
{
    /**
     * Display a listing of tugas akhir.
     */
    public function index(Request $request)
    {
        $query = TugasAkhir::with(['category', 'mahasiswa.user']);

        if ((Auth::user()->role ?? '') === 'mahasiswa') {
            $query->whereHas('mahasiswa', function ($q) {
                $q->where('user_id', Auth::id());
            });
        } elseif ((Auth::user()->role ?? '') !== 'admin') {
            $query->where('status', 'approved');
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim();
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('abstrak', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        $data = $query->orderBy('created_at', 'desc')->orderBy('tahun_lulus', 'desc')
            ->paginate(10)
            ->withQueryString();
        $categories = Kategori::all();
        $totalTugas = $data->total();
        $totalMahasiswa = $data->sum(fn ($item) => $item->mahasiswa->count());

        return view('tugas_akhir.index', compact('data', 'categories', 'totalTugas', 'totalMahasiswa'))
            ->with([
                'search' => $request->input('search'),
                'kategori_id' => $request->input('kategori_id'),
                'tahun_lulus' => $request->input('tahun_lulus'),
            ]);
    }

    /**
     * Store a newly created tugas akhir.
     * Only admin and dosen can create.
     */
    public function store(Request $request)
    {
        $userRole = Auth::user()->role ?? 'guest';

        if (!in_array($userRole, ['admin', 'mahasiswa'])) {
            abort(403, 'Unauthorized to create tugas akhir.');
        }

        $request->validate([
            'judul'               => 'required|string|max:255',
            'abstrak'             => 'required|string',
            'tahun_lulus'         => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori_id'         => 'required|exists:kategori,id',
            'file_laporan'        => 'required|file|mimes:pdf|max:2048',
            'surat_administrasi'  => 'required|file|mimes:pdf|max:2048',
            'score_toeic'         => 'required|file|mimes:pdf|max:2048',
            'sertikom'            => 'required|file|mimes:pdf|max:2048',
            'file_skkm'           => 'required|file|mimes:pdf|max:2048',
            'link_repository'     => 'required|url',
            'demo_video'          => 'required|url',
        ]);

        try {
            $filename = Str::random(10) . '_' . time() . '.pdf';

            $suratPath = $request->file('surat_administrasi')->storeAs('pending/surat_administrasi', Str::random(10) . '_' . time() . '.pdf', 'public');
            $scorePath = $request->file('score_toeic')->storeAs('pending/score_toeic', Str::random(10) . '_' . time() . '.pdf', 'public');
            $sertikomPath = $request->file('sertikom')->storeAs('pending/sertikom', Str::random(10) . '_' . time() . '.pdf', 'public');
            $skkmPath = $request->file('file_skkm')->storeAs('pending/file_skkm', Str::random(10) . '_' . time() . '.pdf', 'public');

            // Jika pengirim adalah mahasiswa, simpan ke folder pending dan tandai belum disetujui
            if ($userRole === 'mahasiswa') {
                $pendingPath = $request->file('file_laporan')->storeAs('pending', $filename, 'public');

                $tugas = TugasAkhir::create([
                    'judul'               => $request->judul,
                    'abstrak'             => $request->abstrak,
                    'tahun_lulus'         => (int) $request->tahun_lulus,
                    'kategori_id'         => $request->kategori_id,
                    'pending_file'        => $pendingPath,
                    'surat_administrasi'  => $suratPath,
                    'score_toeic'         => $scorePath,
                    'sertikom'            => $sertikomPath,
                    'file_skkm'           => $skkmPath,
                    'status'              => 'pending',
                    'is_approved'         => false,
                    'link_repository'     => $request->link_repository,
                    'demo_video'          => $request->demo_video,
                ]);

                $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
                if ($mahasiswa) {
                    $tugas->mahasiswa()->attach($mahasiswa->id);
                }

                return redirect()->route('tugas_akhir.index')
                    ->with('success', 'Data terkirim. Menunggu verifikasi admin sebelum laporan tampil.');
            }

            // Untuk admin: simpan langsung sebagai publik dan set disetujui
            $filePath = $request->file('file_laporan')->storeAs('laporan', $filename, 'public');
            $suratPath = $request->file('surat_administrasi')->storeAs('laporan/surat_administrasi', Str::random(10) . '_' . time() . '.pdf', 'public');
            $scorePath = $request->file('score_toeic')->storeAs('laporan/score_toeic', Str::random(10) . '_' . time() . '.pdf', 'public');
            $sertikomPath = $request->file('sertikom')->storeAs('laporan/sertikom', Str::random(10) . '_' . time() . '.pdf', 'public');
            $skkmPath = $request->file('file_skkm')->storeAs('laporan/file_skkm', Str::random(10) . '_' . time() . '.pdf', 'public');

            TugasAkhir::create([
                'judul'               => $request->judul,
                'abstrak'             => $request->abstrak,
                'tahun_lulus'         => (int) $request->tahun_lulus,
                'kategori_id'         => $request->kategori_id,
                'file_laporan'        => $filePath,
                'surat_administrasi'  => $suratPath,
                'score_toeic'         => $scorePath,
                'sertikom'            => $sertikomPath,
                'file_skkm'           => $skkmPath,
                'status'              => 'approved',
                'is_approved'         => true,
                'link_repository'     => $request->link_repository,
                'demo_video'          => $request->demo_video,
            ]);

            return redirect()->route('tugas_akhir.index')
                ->with('success', 'Tugas Akhir berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menambahkan Tugas Akhir: ' . $e->getMessage()]);
        }
    }

    /**
     * Approve a pending tugas akhir (admin only).
     */
    public function approve($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized to approve tugas akhir.');
        }

        $tugas = TugasAkhir::findOrFail($id);
        $response = null;

        if (! $tugas->pending_file) {
            $response = redirect()->back()->withErrors(['error' => 'Tidak ada file pending untuk disetujui.']);
        } else {
            try {
                $pending = $tugas->pending_file;
                $filename = basename($pending);
                $finalPath = 'laporan/' . $filename;

                // Pastikan file pending ada
                if (! Storage::disk('public')->exists($pending)) {
                    $response = redirect()->back()->withErrors(['error' => 'File pending tidak ditemukan.']);
                } else {
                    // Pindahkan file ke folder publik laporan
                    Storage::disk('public')->move($pending, $finalPath);

                    $tugas->file_laporan = $finalPath;
                    $tugas->pending_file = null;
                    $tugas->status = 'approved';
                    $tugas->is_approved = true;
                    $tugas->save();

                    $response = redirect()->route('tugas_akhir.index')->with('success', 'Tugas Akhir telah disetujui dan diunggah.');
                }
            } catch (\Exception $e) {
                $response = redirect()->back()->withErrors(['error' => 'Gagal menyetujui tugas akhir: ' . $e->getMessage()]);
            }
        }

        return $response;
    }

    /**
     * Reject a pending tugas akhir (admin only).
     */
    public function reject(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized to reject tugas akhir.');
        }

        $tugas = TugasAkhir::findOrFail($id);

        if ($tugas->status !== 'pending') {
            return redirect()->back()->withErrors(['error' => 'Hanya tugas akhir yang masih pending yang bisa ditolak.']);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        try {
            $tugas->status = 'rejected';
            $tugas->is_approved = false;
            $tugas->rejection_reason = $request->rejection_reason;
            $tugas->save();

            return redirect()->route('tugas_akhir.index')->with('success', 'Tugas Akhir telah ditolak dan catatan dikirim ke mahasiswa.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menolak tugas akhir: ' . $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $tugasAkhir = TugasAkhir::findOrFail($id);

        $isMahasiswaOwner = $tugasAkhir->mahasiswa()->where('user_id', Auth::id())->exists();

        if (Auth::user()->role !== 'admin' && ! $isMahasiswaOwner) {
            abort(403, 'Unauthorized to edit tugas akhir.');
        }

        return response()->json($tugasAkhir);
    }


    public function update(Request $request, $id)
    {
        $tugasAkhir = TugasAkhir::findOrFail($id);
        $userRole = Auth::user()->role ?? 'guest';

        $isMahasiswaOwner = $tugasAkhir->mahasiswa()->where('user_id', Auth::id())->exists();

        if ($userRole === 'admin') {
            $allowed = true;
        } elseif ($userRole === 'mahasiswa' && $isMahasiswaOwner && in_array($tugasAkhir->status, ['rejected', 'pending', 'approved'])) {
            $allowed = true;
        } else {
            $allowed = false;
        }

        if (! $allowed) {
            abort(403, 'Unauthorized to update tugas akhir.');
        }

        $request->validate([
            'judul'               => 'required|string|max:255',
            'abstrak'             => 'required|string',
            'tahun_lulus'         => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'kategori_id'         => 'required|exists:kategori,id',
            'file_laporan'        => 'nullable|file|mimes:pdf|max:2048',
            'surat_administrasi'  => 'nullable|file|mimes:pdf|max:2048',
            'score_toeic'         => 'nullable|file|mimes:pdf|max:2048',
            'sertikom'            => 'nullable|file|mimes:pdf|max:2048',
            'file_skkm'           => 'nullable|file|mimes:pdf|max:2048',
            'link_repository'     => 'nullable|url',
            'demo_video'          => 'nullable|url',
        ]);

        try {
            $isOwnerEditingApproved = $userRole === 'mahasiswa' && $isMahasiswaOwner && $tugasAkhir->status === 'approved';

            if ($request->hasFile('file_laporan')) {
                if ($tugasAkhir->file_laporan && Storage::disk('public')->exists($tugasAkhir->file_laporan)) {
                    Storage::disk('public')->delete($tugasAkhir->file_laporan);
                }

                $filename = Str::random(10) . '_' . time() . '.pdf';
                if ($isOwnerEditingApproved) {
                    $tugasAkhir->file_laporan = $request->file('file_laporan')->storeAs('laporan', $filename, 'public');
                    $tugasAkhir->pending_file = null;
                } else {
                    $tugasAkhir->pending_file = $request->file('file_laporan')->storeAs('pending', $filename, 'public');
                    $tugasAkhir->file_laporan = null;
                }
            }

            if ($request->hasFile('surat_administrasi')) {
                if ($tugasAkhir->surat_administrasi && Storage::disk('public')->exists($tugasAkhir->surat_administrasi)) {
                    Storage::disk('public')->delete($tugasAkhir->surat_administrasi);
                }
                $path = $isOwnerEditingApproved ? 'laporan/surat_administrasi' : 'pending/surat_administrasi';
                $tugasAkhir->surat_administrasi = $request->file('surat_administrasi')->storeAs($path, Str::random(10) . '_' . time() . '.pdf', 'public');
            }

            if ($request->hasFile('score_toeic')) {
                if ($tugasAkhir->score_toeic && Storage::disk('public')->exists($tugasAkhir->score_toeic)) {
                    Storage::disk('public')->delete($tugasAkhir->score_toeic);
                }
                $path = $isOwnerEditingApproved ? 'laporan/score_toeic' : 'pending/score_toeic';
                $tugasAkhir->score_toeic = $request->file('score_toeic')->storeAs($path, Str::random(10) . '_' . time() . '.pdf', 'public');
            }

            if ($request->hasFile('sertikom')) {
                if ($tugasAkhir->sertikom && Storage::disk('public')->exists($tugasAkhir->sertikom)) {
                    Storage::disk('public')->delete($tugasAkhir->sertikom);
                }
                $path = $isOwnerEditingApproved ? 'laporan/sertikom' : 'pending/sertikom';
                $tugasAkhir->sertikom = $request->file('sertikom')->storeAs($path, Str::random(10) . '_' . time() . '.pdf', 'public');
            }

            if ($request->hasFile('file_skkm')) {
                if ($tugasAkhir->file_skkm && Storage::disk('public')->exists($tugasAkhir->file_skkm)) {
                    Storage::disk('public')->delete($tugasAkhir->file_skkm);
                }
                $path = $isOwnerEditingApproved ? 'laporan/file_skkm' : 'pending/file_skkm';
                $tugasAkhir->file_skkm = $request->file('file_skkm')->storeAs($path, Str::random(10) . '_' . time() . '.pdf', 'public');
            }

            if ($userRole === 'mahasiswa') {
                if ($isOwnerEditingApproved) {
                    $tugasAkhir->status = 'approved';
                    $tugasAkhir->is_approved = true;
                } else {
                    $tugasAkhir->status = 'pending';
                    $tugasAkhir->is_approved = false;
                    $tugasAkhir->rejection_reason = null;
                }
            }

            $tugasAkhir->update([
                'judul'               => $request->judul,
                'abstrak'             => $request->abstrak,
                'tahun_lulus'         => (int) $request->tahun_lulus,
                'kategori_id'         => $request->kategori_id,
                'link_repository'     => $request->link_repository,
                'demo_video'          => $request->demo_video,
                'file_laporan'        => $tugasAkhir->file_laporan,
                'pending_file'        => $tugasAkhir->pending_file,
                'surat_administrasi'  => $tugasAkhir->surat_administrasi,
                'score_toeic'         => $tugasAkhir->score_toeic,
                'sertikom'            => $tugasAkhir->sertikom,
                'file_skkm'           => $tugasAkhir->file_skkm,
                'status'              => $tugasAkhir->status,
                'is_approved'         => $tugasAkhir->is_approved,
                'rejection_reason'    => $tugasAkhir->rejection_reason,
            ]);

            $response = redirect()->route('tugas_akhir.index')
                ->with('success', 'Tugas Akhir berhasil diperbarui.');

            if ($userRole === 'mahasiswa' && ! $isOwnerEditingApproved) {
                $response->with('info', 'Pengajuan dikirim ulang dan menunggu verifikasi admin.');
            }

            return $response;
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui Tugas Akhir: ' . $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        // Authorization check
        if (!in_array(Auth::user()->role, ['admin'])) {
            abort(403, 'Unauthorized to delete tugas akhir.');
        }

        try {
            $tugasAkhir = TugasAkhir::findOrFail($id);

            // Detach any pivot relations first to avoid foreign key constraint errors
            $tugasAkhir->mahasiswa()->detach();

            // Delete file if exists
            if ($tugasAkhir->file_laporan && Storage::disk('public')->exists($tugasAkhir->file_laporan)) {
                Storage::disk('public')->delete($tugasAkhir->file_laporan);
            }

            $tugasAkhir->delete();

            return redirect()->route('tugas_akhir.index')
                ->with('success', 'Tugas Akhir berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus Tugas Akhir: ' . $e->getMessage()]);
        }
    }

    /**
     * View laporan file (PDF) - protected by auth middleware in routes/web.php
     */
    public function lihatLaporan($id)
    {
        $tugasAkhir = TugasAkhir::findOrFail($id);

        abort_if(! $tugasAkhir->file_laporan, 404);

        $absolutePath = storage_path('app/public/' . $tugasAkhir->file_laporan);

        if (! file_exists($absolutePath)) {
            abort(404);
        }

        return response()->file($absolutePath);
    }
}

