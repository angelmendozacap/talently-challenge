<?php

use App\Http\Controllers\API\PhaseWorkApplicationController;
use App\Http\Controllers\API\WorkApplicationController;
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

// Applications
Route::post('/applications', [WorkApplicationController::class, 'store'])->name('api.applications.store');
Route::get('/applications/{application}', [WorkApplicationController::class, 'show'])->name('api.applications.show');
Route::put('/applications/{application}', [WorkApplicationController::class, 'update'])->name('api.applications.update');
Route::delete('/applications/{application}', [WorkApplicationController::class, 'destroy'])->name('api.applications.destroy');

// PhaseWorkApplication
Route::patch('/applications/{application}/change-phase', [PhaseWorkApplicationController::class, 'change'])->name('api.phase.applications.change');
