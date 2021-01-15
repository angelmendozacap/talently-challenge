<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\WorkApplicationController;
use App\Http\Controllers\API\V1\PhaseWorkApplicationController;
use App\Http\Controllers\API\V1\ReportController;

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

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Applications
    Route::get('/applications', [WorkApplicationController::class, 'index'])->name('v1.applications.index');
    Route::post('/applications', [WorkApplicationController::class, 'store'])->name('v1.applications.store');
    Route::get('/applications/{application}', [WorkApplicationController::class, 'show'])->name('v1.applications.show');
    Route::put('/applications/{application}', [WorkApplicationController::class, 'update'])->name('v1.applications.update');
    Route::delete('/applications/{application}', [WorkApplicationController::class, 'destroy'])->name('v1.applications.destroy');

    // PhaseWorkApplication
    Route::patch('/applications/{application}/change-phase', [PhaseWorkApplicationController::class, 'change'])->name('v1.phase.applications.change');

    // Reports
    Route::get('/generated-reports', [ReportController::class, 'index']);

});

require __DIR__ . '/auth.php';
