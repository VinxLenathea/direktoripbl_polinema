<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasAkhirController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Tugas Akhir Routes
    Route::get('/tugas-akhir', [TugasAkhirController::class, 'index'])->name('tugas_akhir.index');
    Route::post('/tugas-akhir/store', [TugasAkhirController::class, 'store'])->name('tugas_akhir.store');
    Route::get('/tugas-akhir/{id}/edit', [TugasAkhirController::class, 'edit'])->name('tugas_akhir.edit');
    Route::put('/tugas-akhir/{id}', [TugasAkhirController::class, 'update'])->name('tugas_akhir.update');
    Route::delete('/tugas-akhir/{id}', [TugasAkhirController::class, 'destroy'])->name('tugas_akhir.destroy');
});

require __DIR__ . '/auth.php';
