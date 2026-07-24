<?php

namespace App\Http\Controllers;


use App\Models\Mahasiswa;
use App\Models\TugasAkhir;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class MahasiswaController extends Controller
{
    private function getMahasiswaMetrics()
    {
        $authUser = auth()->guard('web')->user();
        abort_unless(($authUser?->role ?? '') === 'mahasiswa', 403);

        $userId = $authUser->id;

        $mahasiswa = Mahasiswa::query()->where('user_id', $userId)->first();
        $mahasiswaId = $mahasiswa?->id;

        // Pastikan data yang ditampilkan benar-benar milik mahasiswa login
        // (berdasarkan relasi pivot: tugas_akhir <-> mahasiswa melalui tugas_akhir_mahasiswa)
        $baseQuery = TugasAkhir::with(['category', 'mahasiswa'])
            ->whereHas('mahasiswa', function ($q) use ($mahasiswaId) {
                $q->where('mahasiswa.id', $mahasiswaId);
            });

        $totalTugasAkhirSaya = (clone $baseQuery)->count();
        $totalApproved = (clone $baseQuery)->where('status', 'approved')->count();
        $totalPending = (clone $baseQuery)->where('status', 'pending')->count();
        $totalRejected = (clone $baseQuery)->where('status', 'rejected')->count();

        return [
            'totalTugasAkhirSaya' => $totalTugasAkhirSaya,
            'totalApproved' => $totalApproved,
            'totalPending' => $totalPending,
            'totalRejected' => $totalRejected,
        ];
    }

    public function dashboard(): View
    {
        $authUser = auth()->guard('web')->user();
        abort_unless(($authUser?->role ?? '') === 'mahasiswa', 403);

        $userId = $authUser->id;

        $mahasiswa = Mahasiswa::query()->where('user_id', $userId)->first();
        $mahasiswaId = $mahasiswa?->id;

        $metrics = $this->getMahasiswaMetrics();

        $baseQuery = TugasAkhir::with(['category', 'mahasiswa'])
            ->whereHas('mahasiswa', function ($q) use ($mahasiswaId) {
                $q->where('mahasiswa.id', $mahasiswaId);
            });

        $recentTugasAkhirSaya = (clone $baseQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mahasiswa.mahasiswa', [
            'totalTugasAkhirSaya' => $metrics['totalTugasAkhirSaya'],
            'totalApproved' => $metrics['totalApproved'],
            'totalPending' => $metrics['totalPending'],
            'totalRejected' => $metrics['totalRejected'],
            'recentTugasAkhirSaya' => $recentTugasAkhirSaya,
        ]);
    }

    /**
     * Get metrics data for AJAX/real-time updates
     */
    public function getMetrics(): JsonResponse
    {
        try {
            $metrics = $this->getMahasiswaMetrics();
            return response()->json([
                'success' => true,
                'data' => $metrics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching metrics'
            ], 500);
        }
    }
}

