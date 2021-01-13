<?php

use App\Http\Controllers\WorkApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/applications', [WorkApplicationController::class, 'store'])->name('api.applications.store');
Route::get('/applications/{application}', [WorkApplicationController::class, 'show'])->name('api.applications.show');
Route::put('/applications/{application}', [WorkApplicationController::class, 'update'])->name('api.applications.update');
