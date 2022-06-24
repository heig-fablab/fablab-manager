<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\FileTypeController;
use App\Http\Controllers\Api\JobCategoryController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;

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

// Default
/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// All {id} and {username} parameters are required and validated in RouteServiceProvider file

// TODO: Do we transform all update routes with id given in path?

// TODO: verify acces with middleware
// https://laravel.com/docs/9.x/authorization#via-middleware

// Futur all users routes
Route::prefix('/jobs')->controller(JobController::class)->group(function () {
    Route::get('', 'index'); // admin
    Route::get('/unassigned', 'unassigned_jobs');
    Route::get('/user/{username}', 'user_jobs');
    Route::get('/client/{username}', 'user_as_client_jobs'); // usefull?
    Route::get('/worker/{username}', 'user_as_worker_jobs'); // todo verify role ->middleware() // usefull?
    Route::get('/validator/{username}', 'user_as_validator_jobs'); // todo verify role ->middleware() // usefull?
    Route::get('/{id}', 'show');
    Route::post('', 'store');
    Route::put('', 'update');
    //Route::patch('/{id}/validator/{username}', 'assign_validator'); // todo verify role ->middleware()
    Route::patch('/worker/assign', 'assign_worker'); // todo verify role ->middleware()
    Route::patch('/status', 'update_status'); // todo verify role and user ->middleware()
    Route::patch('/rating', 'update_rating'); // todo verify user ->middleware()
    Route::patch('{id}/notifications', 'update_notifications');
    Route::delete('/{id}', 'destroy');
});

Route::prefix('/files')->controller(FileController::class)->group(function () {
    //Route::get('', 'index');
    Route::get('/{id}', 'show');
    Route::post('', 'store');
    //Route::post('/job/{id}', 'job_files');
    Route::put('', 'update');
    Route::delete('/{id}', 'destroy');
});

Route::prefix('/messages')->controller(MessageController::class)->group(function () {
    Route::get('', 'index');
    Route::get('/{id}', 'show');
    Route::post('', 'store');
    // TODO: perhaps a route to get all messages for a job
});

// Futur admin routes
Route::prefix('/devices')->controller(DeviceController::class)
    //->group(['middleware' => ['can:before,App\Models\Device']], function () {
    ->group(function () {
        Route::get('', 'index');
        Route::get('/{id}', 'show');
        Route::post('', 'store');
        Route::put('', 'update');
        Route::delete('/{id}', 'destroy');
    });

Route::prefix('/file_types')->controller(FileTypeController::class)->group(function () {
    Route::get('', 'index');
    Route::get('/{id}', 'show');
    Route::post('', 'store');
    Route::put('', 'update');
    Route::delete('/{id}', 'destroy');
}); // TODO -> verify admin via middleware

Route::prefix('/job_categories')->controller(JobCategoryController::class)->group(function () {
    Route::get('', 'index');
    Route::get('/{id}', 'show');
    Route::post('', 'store');
    Route::put('', 'update');
    Route::delete('/{id}', 'destroy');
}); // TODO -> verify admin via middleware

Route::prefix('/users')->controller(UserController::class)->group(function () {
    Route::get('', 'index');
    Route::get('/{username}', 'show');
    Route::post('', 'store'); // TODO -> verify admin via middleware
    Route::put('', 'update'); // TODO -> verify admin via middleware
    Route::patch('/notifications', 'update_email_notifications'); // TODO -> verify if connected
    Route::delete('/{username}', 'destroy'); // TODO -> verify admin via middleware
}); // TODO -> verify admin via middleware

/*Route::prefix('/user')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});*/

//Route::group(['middleware' => ['auth']], function () {