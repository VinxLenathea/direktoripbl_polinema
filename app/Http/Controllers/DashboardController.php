<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalMahasiswa' => Mahasiswa::count(),
            'totalTugasAkhir' => TugasAkhir::count(),
            'totalKategori' => Kategori::count(),
            'recentTugasAkhir' => TugasAkhir::with('category')->latest()->limit(5)->get(),
            'recentUsers' => User::latest()->limit(5)->get(),
        ]);
    }

    public function mahasiswaAccounts(): View
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        return view('admin.mahasiswa-accounts', [
            'mahasiswaUsers' => User::with('mahasiswa')
                ->where('role', 'mahasiswa')
                ->latest()
                ->get(),
        ]);
    }

    public function storeMahasiswa(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'nim' => ['required', 'string', 'max:50', Rule::unique('mahasiswa', 'nim')->where(function ($query) {
                    return $query->whereNotNull('user_id');
                })],
                'jurusan' => ['required', 'string', 'max:255'],
                'prodi' => ['required', 'string', 'max:255'],
                'angkatan' => ['required', 'integer'],
            ]);
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('modal_status', 'error')
                ->with('modal_title', 'Gagal membuat akun mahasiswa')
                ->with('modal_message', $this->firstValidationError($e->errors()));
        }

        try {
            DB::transaction(function () use ($validated) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'mahasiswa',
                ]);

                $existingMahasiswa = Mahasiswa::where('nim', $validated['nim'])
                    ->whereNull('user_id')
                    ->first();

                if ($existingMahasiswa) {
                    $existingMahasiswa->update([
                        'user_id' => $user->id,
                        'name' => $validated['name'],
                        'jurusan' => $validated['jurusan'],
                        'prodi' => $validated['prodi'],
                        'angkatan' => $validated['angkatan'],
                    ]);
                } else {
                    Mahasiswa::create([
                        'user_id' => $user->id,
                        'name' => $validated['name'],
                        'nim' => $validated['nim'],
                        'jurusan' => $validated['jurusan'],
                        'prodi' => $validated['prodi'],
                        'angkatan' => $validated['angkatan'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            \Log::error('Failed to create mahasiswa account', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->with('modal_status', 'error')
                ->with('modal_title', 'Gagal membuat akun mahasiswa')
                ->with('modal_message', config('app.debug')
                    ? 'Terjadi kesalahan saat menyimpan akun: ' . $e->getMessage()
                    : 'Terjadi kesalahan saat menyimpan akun. Silakan coba lagi.');
        }

        return redirect()->route('dashboard.mahasiswa.index')
            ->with('modal_status', 'success')
            ->with('modal_title', 'Akun berhasil dibuat')
            ->with('modal_message', 'Akun mahasiswa berhasil dibuat dan tersimpan di halaman akun mahasiswa.');
    }

    public function updateMahasiswa(Request $request, $id): RedirectResponse
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $user = User::with('mahasiswa')
            ->where('role', 'mahasiswa')
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'nim' => ['required', 'string', 'max:50', Rule::unique('mahasiswa', 'nim')->ignore($user->mahasiswa?->id)],
            'jurusan' => ['required', 'string', 'max:255'],
            'prodi' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'integer'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($user, $validated) {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            ]);

            if ($user->mahasiswa) {
                $user->mahasiswa->update([
                    'name' => $validated['name'],
                    'nim' => $validated['nim'],
                    'jurusan' => $validated['jurusan'],
                    'prodi' => $validated['prodi'],
                    'angkatan' => $validated['angkatan'],
                ]);
            } else {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $validated['nim'],
                    'jurusan' => $validated['jurusan'],
                    'prodi' => $validated['prodi'],
                    'angkatan' => $validated['angkatan'],
                ]);
            }
        });

        return redirect()->route('dashboard.mahasiswa.index')
            ->with('success', 'Akun mahasiswa berhasil diperbarui.');
    }

    public function destroyMahasiswa($id): RedirectResponse
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $user = User::with('mahasiswa.tugasAkhir')
            ->where('role', 'mahasiswa')
            ->findOrFail($id);

        DB::transaction(function () use ($user) {
            if ($user->mahasiswa) {
                $user->mahasiswa->update(['user_id' => null]);
            }
            $user->delete();
        });

        return redirect()->route('dashboard.mahasiswa.index')
            ->with('success', 'Akun mahasiswa berhasil dihapus.');
    }

    protected function firstValidationError(array $errors): string
    {
        return collect($errors)
            ->flatten()
            ->first() ?? 'Silakan periksa kembali data yang Anda masukkan.';
    }
}
