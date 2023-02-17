<?php


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

//le rotte dentro api.php in automatico mettono /api davanti al link,
//quindi mettendo /v1/movie/all il risultato sarebbe api/v1/movie/all

use App\Http\Controllers\ApiController;

Route::get('/v1/movie/all', [ApiController::class, 'movieAll']);


