<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TugasAkhirController;
use App\Models\Kategori;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    $totalMahasiswa = Mahasiswa::count();
    $totalProyek = TugasAkhir::where('status', 'approved')->count();
    $categories = Kategori::orderBy('nama_kategori')->get();

    return view('welcome', compact('totalMahasiswa', 'totalProyek', 'categories'));
})->name('welcome');

Route::get('/kategori', function () {
    $search = request()->string('search')->trim();
    $selectedCategory = request()->query('kategori_id');

    $categories = Kategori::orderBy('nama_kategori')->get();

    $projects = TugasAkhir::with(['category', 'mahasiswa.user'])
        ->where('status', 'approved')
        ->when($selectedCategory, function ($query, $selectedCategory) {
            return $query->where('kategori_id', $selectedCategory);
        })
        ->when($search->isNotEmpty(), function ($query) use ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('abstrak', 'like', "%{$search}%");
            });
        })
        ->orderBy('tahun_lulus', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(9)
        ->withQueryString();

    return view('kategori', compact('categories', 'projects', 'selectedCategory', 'search'));
})->name('kategori.showcase');


Route::get('/showcase', function () {
    $categories = Kategori::withCount(['tugasAkhirs as approved_projects_count' => function ($query) {
        $query->where('status', 'approved');
    }])->orderBy('nama_kategori')->paginate(9);

    return view('showcase', compact('categories'));
})->name('showcase');

Route::get('/showcase/{kategori:slug}', function (Kategori $kategori) {
    $projects = TugasAkhir::with(['category', 'mahasiswa.user'])
        ->where('kategori_id', $kategori->id)
        ->where('status', 'approved')
        ->orderBy('tahun_lulus', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(9);

    return view('showcase-category', compact('kategori', 'projects'));
})->name('showcase.category');

Route::get('/showcase/{kategori:slug}/{tugasAkhir:slug}', function (Kategori $kategori, TugasAkhir $tugasAkhir) {
    if ($tugasAkhir->kategori_id !== $kategori->id || $tugasAkhir->status !== 'approved') {
        abort(404);
    }

    $tugasAkhir->load(['category', 'mahasiswa.user']);

    return view('showcase-project', compact('kategori', 'tugasAkhir'));
})->name('showcase.project');


use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/mahasiswa-akun', [DashboardController::class, 'mahasiswaAccounts'])
    ->middleware(['auth'])
    ->name('dashboard.mahasiswa.index');

Route::post('/dashboard/mahasiswa', [DashboardController::class, 'storeMahasiswa'])
    ->middleware(['auth'])
    ->name('dashboard.mahasiswa.store');

Route::put('/dashboard/mahasiswa/{mahasiswa}', [DashboardController::class, 'updateMahasiswa'])
    ->middleware(['auth'])
    ->name('dashboard.mahasiswa.update');

Route::delete('/dashboard/mahasiswa/{mahasiswa}', [DashboardController::class, 'destroyMahasiswa'])
    ->middleware(['auth'])
    ->name('dashboard.mahasiswa.destroy');

Route::middleware(['auth'])->group(function () {
    Route::get('/kategori-admin', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mahasiswa/dashboard', [\App\Http\Controllers\MahasiswaController::class, 'dashboard'])
        ->middleware('auth')
        ->name('mahasiswa.dashboard');



    // Tugas Akhir Routes - viewable by all authenticated users


    Route::get('/tugas-akhir', [TugasAkhirController::class, 'index'])->name('tugas_akhir.index');

    // Laporan view (protected)
    Route::get('/laporan/{id}', [TugasAkhirController::class, 'lihatLaporan'])
        ->name('laporan.view');


    // CRUD operations - authorization checks in controller
    Route::post('/tugas-akhir/store', [TugasAkhirController::class, 'store'])->name('tugas_akhir.store');
    Route::get('/tugas-akhir/{id}/edit', [TugasAkhirController::class, 'edit'])->name('tugas_akhir.edit');
    Route::put('/tugas-akhir/{id}', [TugasAkhirController::class, 'update'])->name('tugas_akhir.update');
    Route::delete('/tugas-akhir/{id}', [TugasAkhirController::class, 'destroy'])->name('tugas_akhir.destroy');
    Route::post('/tugas-akhir/{id}/approve', [TugasAkhirController::class, 'approve'])->name('tugas_akhir.approve');
    Route::post('/tugas-akhir/{id}/reject', [TugasAkhirController::class, 'reject'])->name('tugas_akhir.reject');
});

require __DIR__ . '/auth.php';


