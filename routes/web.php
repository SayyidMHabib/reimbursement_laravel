<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengajuanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/pengajuan', function () {
        return view('pengajuan', [
            'title' => 'Data Pengajuan',
            'active' => 'pengajuan',
        ]);
    });
    Route::get('/pengajuan/data', [PengajuanController::class, 'index']);
    Route::get('/pengajuan/{id}/edit', [PengajuanController::class, 'edit']);
    Route::post('/pengajuan/{id}', [PengajuanController::class, 'update']);
    Route::delete('/pengajuan/{id}', [PengajuanController::class, 'destroy']);
    Route::post('/approve_pengajuan/{id}', [PengajuanController::class, 'approve_pengajuan']);
    Route::post('/tolak_pengajuan/{id}', [PengajuanController::class, 'tolak_pengajuan']);
});

Route::middleware('auth')->group(function () {
    Route::get('/user', function () {
        return view('user', [
            'title' => 'Data user',
            'active' => 'user',
        ]);
    });
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::post('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
});

require __DIR__ . '/auth.php';
