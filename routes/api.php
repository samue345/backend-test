<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RedirectsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('redirects', RedirectsController::class);


Route::prefix('redirects')->group(function () {
    Route::get('/{redirect}/stats', [RedirectsController::class, 'showStats'])->name('redirects.stats');
    Route::get('/{redirect}/logs', [RedirectsController::class, 'showLogs'])->name('redirects.logs');
});