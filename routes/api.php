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

// All {id} and {username} parameters are required and validated in RouteServiceProvider file

// TODO: Do we transform all update routes with id given in path?

Route::middleware('auth:api')->group(function () {

    Route::prefix('/jobs')->controller(JobController::class)->group(function () {
        Route::get('', 'index')->can('viewAny', 'App\Models\Job');
        Route::get('/unassigned', 'unassigned_jobs')->can('unassigned_jobs,App\Models\Job');
        Route::get('/user/{username}', 'user_jobs')->can('user_jobs,App\Models\Job');
        Route::get('/client/{username}', 'user_as_client_jobs')->can('user_as_client_jobs,App\Models\Job'); // usefull?
        Route::get('/worker/{username}', 'user_as_worker_jobs')->can('user_as_worker_jobs,App\Models\Job'); // usefull?
        Route::get('/validator/{username}', 'user_as_validator_jobs')->can('user_as_validator_jobs,App\Models\Job'); // usefull?
        Route::get('/{id}', 'show')->can('view,job');
        Route::post('', 'store')->can('store,App\Models\Job');
        Route::put('', 'update')->can('update,job');
        //Route::patch('/{id}/validator/{username}', 'assign_validator')->can('assign_validator,App\Models\Job');
        Route::patch('/worker/assign', 'assign_worker')->can('assign_worker,App\Models\Job');
        Route::patch('/status', 'update_status')->can('update_status,job');
        Route::patch('/rating', 'update_rating')->can('update_rating,job');
        Route::patch('{id}/notifications/user/{username}', 'update_notifications')->can('update_notifications,job');
        Route::delete('/{id}', 'destroy')->can('destroy,job');
    });

    Route::prefix('/files')->controller(FileController::class)->group(function () {
        //Route::get('', 'index')->can('viewAny', 'App\Models\File');
        Route::get('/{id}', 'show')->can('view,file');
        Route::post('', 'store')->can('store,App\Models\File');
        //Route::post('/job/{id}', 'job_files');
        Route::put('', 'update')->can('update,file');
        Route::delete('/{id}', 'destroy');
    });

    Route::prefix('/messages')->controller(MessageController::class)->group(function () {
        Route::get('', 'index')->can('viewAny', 'App\Models\Job');
        Route::get('/{id}', 'show')->can('view,message');
        Route::post('', 'store')->can('store,App\Models\Message');
        // TODO: perhaps a route to get all messages for a job
    });

    Route::prefix('/users')->controller(UserController::class)->group(function () {
        Route::get('', 'index')->can('viewAny', 'App\Models\User');
        Route::get('/{username}', 'show')->can('view', 'user');
        Route::post('', 'store')->can('create', 'App\Models\User');
        Route::put('', 'update')->can('update', 'user');
        Route::patch('/notifications', 'update_email_notifications')->can('update_email_notifications', 'user');
        Route::delete('/{username}', 'destroy')->can('delete', 'App\Models\User');
    });

    // Admin routes
    Route::prefix('/devices')
        ->controller(DeviceController::class)
        ->middleware('can:before,App\Models\Device')
        ->group(function () {
            Route::get('', 'index');
            Route::get('/{id}', 'show');
            Route::post('', 'store');
            Route::put('', 'update');
            Route::delete('/{id}', 'destroy');
        });

    Route::prefix('/file_types')
        ->controller(FileTypeController::class)
        ->middleware('can:before,App\Models\FileType')
        ->group(function () {
            Route::get('', 'index');
            Route::get('/{id}', 'show');
            Route::post('', 'store');
            Route::put('', 'update');
            Route::delete('/{id}', 'destroy');
        });

    Route::prefix('/job_categories')
        ->controller(JobCategoryController::class)
        ->middleware('can:before,App\Models\JobCategory')
        ->group(function () {
            Route::get('', 'index');
            Route::get('/{id}', 'show');
            Route::post('', 'store');
            Route::put('', 'update');
            Route::delete('/{id}', 'destroy');
        });
});
