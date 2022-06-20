<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//<test route>
Route::any('/admin', function () {
    return view('app');
})->where('all', '^(?!api).*$')->middleware('auth.basic');
//</test route>

Route::name('app')->any('{all}', function () {
    return view('app');
})->where('all', '^(?!api).*$'); //->middleware('auth');

Route::name('welcome')->any('/welcome', function () {
    return view('welcome');
});
