<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
});
Route::get('/getBanner',[BannerController::class,'getBanner']);
Route::post('/insert_Banner',[BannerController::class,'insert_Banner']);

Route::get('/getUser',[UserController::class,'getUser']);
Route::get('/users_status_update',[UserController::class,'users_status_update']);
