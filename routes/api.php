<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('devices', DeviceController::class);

Route::apiResource('files', FileController::class);

Route::apiResource('file_types', FileTypeController::class);

Route::apiResource('job_categories', JobCategoryController::class);

Route::apiResource('jobs', JobController::class);

Route::apiResource('messages', MessageController::class);

Route::apiResource('users', UserController::class);

/*Route::prefix('/user')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});
  
Route::group(['middleware' => ['auth']], function () {

    Route::prefix('/user')->group(function () {
        Route::get('/retrieve', function() { return Auth::user(); });
        Route::post('/update-settings', [UserController::class, 'updateSettings']);
    });

    Route::get('/jobs/{id}', [JobController::class, 'index']);
    Route::prefix('/job')->group(function () { 
        Route::post('/store', [JobController::class, 'store']);
        Route::post('/update-status', [JobController::class, 'updateStatus']);
        Route::post('/update-notify', [JobController::class, 'updateNotify']);
        Route::post('/assign', [JobController::class, 'assign']);
        Route::post('/terminate', [JobController::class, 'terminate']);
    });

    Route::prefix('/message')->group(function () { 
        Route::post('/store', [MessageController::class, 'store']);
    });

    Route::prefix('/file')->group(function () { 
        Route::post('/store', [FileController::class, 'store']);
        Route::get('/download/{id}', [FileController::class, 'download']);
    });
});*/