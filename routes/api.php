<?php

use App\Http\Controllers\FruitsController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoSerieController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/videos/{id}', [VideoController::class, 'getVideo']);
Route::get('/videos', [VideoController::class, 'getVideos']);

Route::get('/series', [SerieController::class, 'getSeries']);

Route::get('/series/{serie}/videos', [VideoSerieController::class, 'index']);

Route::get('/fruits/{id}', [FruitsController::class, 'getFruit']);
