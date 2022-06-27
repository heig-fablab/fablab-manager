<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\FileTypeController;
use App\Http\Controllers\Api\JobCategoryController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use App\Models\Job;
use App\Models\File;
use App\Models\Message;
use App\Models\User;

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

// TODO: Do we transform all update (put and patch) routes with id given in path?

Route::middleware('auth:api')->group(function () {

    Route::prefix('/jobs')->controller(JobController::class)->group(function () {
        Route::get('', 'index')->can('viewAny', Job::class);
        Route::get('/unassigned', 'unassigned_jobs')->can('unassigned_jobs', Job::class);
        Route::get('/user/{username}', 'user_jobs')->can('user_jobs', [Job::class, 'username']);
        Route::get('/client/{username}', 'user_as_client_jobs')->can('user_as_client_jobs', [Job::class, 'username']); // usefull?
        Route::get('/worker/{username}', 'user_as_worker_jobs')->can('user_as_worker_jobs', [Job::class, 'username']); // usefull?
        Route::get('/validator/{username}', 'user_as_validator_jobs')->can('user_as_validator_jobs', [Job::class, 'username']); // usefull?
        Route::get('/{id}', 'show')->can('view', [Job::class, 'id']);
        Route::post('', 'store')->can('create', Job::class);
        Route::put('', 'update')->can('update', Job::class);
        //Route::patch('/{id}/validator/{username}', 'assign_validator')->can('assign_validator', Job::class);
        Route::patch('/worker/assign', 'assign_worker')->can('assign_worker', Job::class);
        Route::patch('/status', 'update_status')->can('update_status', Job::class);
        Route::patch('/rating', 'update_rating')->can('update_rating', Job::class);
        Route::patch('{id}/notifications/user/{username}', 'update_notifications')->can('update_notifications', [Job::class, 'id', 'username']);
        Route::delete('/{id}', 'destroy')->can('destroy', [Job::class, 'id']);
    });

    Route::prefix('/files')->controller(FileController::class)->group(function () {
        //Route::get('', 'index')->can('viewAny', File::class);
        Route::get('/{id}', 'show')->can('view', [File::class, 'id']);
        Route::post('', 'store')->can('create', File::class);
        //Route::post('/job/{id}', 'job_files')->can('job_files', [File::class, 'id']);
        Route::put('', 'update')->can('update', File::class);
        Route::delete('/{id}', 'destroy')->can('destroy', [File::class, 'id']);
    });

    Route::prefix('/messages')->controller(MessageController::class)->group(function () {
        Route::get('', 'index')->can('viewAny', Message::class);
        Route::get('/{id}', 'show')->can('view', [Message::class, 'id']);
        Route::post('', 'store')->can('create', Message::class);
        // TODO: perhaps a route to get all messages for a job
    });

    Route::prefix('/users')->controller(UserController::class)->group(function () {
        Route::get('', 'index')->can('viewAny', User::class);
        Route::get('/{username}', 'show')->can('view', [User::class, 'username']);
        Route::post('', 'store')->can('create', User::class);
        Route::put('', 'update')->can('update', 'user');
        Route::patch('/notifications', 'update_email_notifications')->can('update_email_notifications', User::class);
        Route::delete('/{username}', 'destroy')->can('delete', [User::class, 'username']);
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
