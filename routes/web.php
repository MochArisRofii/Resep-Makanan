<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PostController;
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
Route::get('/', [ResepController::class, 'index'])->name('home')->middleware('auth');


// Rute CRUD untuk resep
Route::resource('reseps', ResepController::class);
Route::get('bahans/{resep_id}', [ResepController::class, 'show'])->name('reseps.show');


// Rute CRUD untuk Bahan
Route::resource('bahans', BahanController::class);

// Mendefinisikan route GET untuk menampilkan formulir pembuatan bahan
Route::get('bahans/create/{resep_id}', [BahanController::class, 'create'])->name('bahans.create');

// Mendefinisikan route POST untuk menyimpan data bahan baru
Route::post('bahans', [BahanController::class, 'store'])->name('bahans.store');


// Rute ini digunakan untuk menangani permintaan HTTP POST yang dikirim ke endpoint /bahans/update-position.
// Endpoint ini biasanya digunakan untuk memperbarui posisi bahan (misalnya, urutan atau posisi bahan dalam resep) di database.
Route::post('/bahans/update-position', [BahanController::class, 'updatePosition'])->name('bahans.updatePosition');

// Halaman login
Route::get('login', [AuthController::class, 'loginForm'])->name('login');

// Proses login
Route::post('login', [AuthController::class, 'login'])->name('login.submit');

// Proses logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


    