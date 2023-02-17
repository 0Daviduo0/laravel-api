<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;

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

Route::get('/', [MainController::class, 'home'])->name('home');
Route::get('/movie', [MainController::class, 'movie'])->name('home.movie');

//crea Film
Route::get('/movie/create', [MainController::class, 'create'])->name('movie.create');
//salva il Film
Route::post('/movie/create', [MainController::class, 'store'])->name('movie.store');

//modifica Film
Route::get('/movie/edit/{movie}', [MainController::class, 'edit'])-> name('movie.edit');
//aggiorna Film
Route::post('/movie/edit/{movie}', [MainController::class, 'update'])-> name('movie.update');

//elimina Film
Route::get('/movie/delete/{movie}', [MainController::class, 'delete'])-> name('movie.delete');



