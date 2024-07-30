<?php

use App\Http\Controllers\BahanController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Halaman depan yang menampilkan daftar resep
Route::get('/', [ResepController::class, 'index'])->name('home');


// Rute CRUD untuk resep
Route::resource('reseps', ResepController::class);
Route::get('bahans/{resep}', [ResepController::class, 'show'])->name('reseps.show');


// Rute CRUD untuk Bahan
Route::resource('bahans', BahanController::class);
Route::get('bahans/create/{resep_id}', [BahanController::class, 'create'])->name('bahans.create');
Route::post('bahans', [BahanController::class, 'store'])->name('bahans.store');


// Rute ini digunakan untuk menangani permintaan HTTP POST yang dikirim ke endpoint /bahans/update-position.
// Endpoint ini biasanya digunakan untuk memperbarui posisi bahan (misalnya, urutan atau posisi bahan dalam resep) di database.

Route::post('/bahans/update-position', [BahanController::class, 'updatePosition'])->name('bahans.updatePosition');