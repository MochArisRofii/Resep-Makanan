<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\ResepController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('reseps')->group(function () {
    Route::get('/', [ResepController::class, 'index']); // GET semua reseps
    Route::post('/', [ResepController::class, 'store']); // POST untuk membuat reseps baru
    Route::get('/{id}', [ResepController::class, 'show']); // GET detail resep
    Route::put('/{resep}', [ResepController::class, 'update']); // PUT untuk update resep
    Route::delete('/{resep}', [ResepController::class, 'destroy']); // DELETE untuk menghapus resep
});

Route::prefix('bahans')->group(function () {
    Route::get('/', [BahanController::class, 'index']); // GET semua bahan
    Route::post('/', [BahanController::class, 'store']); // POST untuk membuat bahan baru
    Route::get('/{bahan}', action: [BahanController::class, 'show']); // GET detail bahan
    Route::put('/{bahan}', [BahanController::class, 'update']); // PUT untuk update bahan
    Route::delete('/{bahan}', [BahanController::class, 'destroy']); // DELETE untuk menghapus bahan
    Route::put('/update-position', [BahanController::class, 'updatePosition']); // Update posisi bahan
});