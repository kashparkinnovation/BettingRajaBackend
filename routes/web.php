<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SlotGameController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiceGameController;
use App\Http\Controllers\JhatkaController;
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

Route::get('/', [LoginController::class, 'checkAuth']);
Route::get('/login', function () {
    return view('login');
});
Route::post('/loginf', [LoginController::class, 'loginfunc']);

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/getBanner', [BannerController::class, 'getBanner']);
    Route::post('/insert_Banner', [BannerController::class, 'insert_Banner']);
    Route::get('/delete_Banner', [BannerController::class, 'delete_Banner']);
    Route::get('/getUser', [UserController::class, 'getUser']);
    Route::get('/users_status_update', [UserController::class, 'users_status_update']);
    Route::get('/slot_game', [SlotGameController::class, 'slot_game']);
    Route::get('/dice_game', [DiceGameController::class, 'dice_game']);
    Route::post('/update_slot_game', [SlotGameController::class, 'update_slot_game']);
    
    Route::get('/withdrawReq', [UserController::class, 'withdrawReq']);
    Route::get('/cancelWithdrawReq', [UserController::class, 'cancelWithdrawReq']);
    
    Route::get('/UpdateWithdrawReq', [UserController::class, 'UpdateWithdrawReq']);
   
    Route::get('/rechargeReq', [UserController::class, 'rechargeReq']);
    Route::get('/cancelrechargeReq', [UserController::class, 'cancelrechargeReq']);
    
    Route::get('/UpdaterechargeReq', [UserController::class, 'UpdaterechargeReq']);
    
    
    Route::get('/jhatkaGame', [JhatkaController::class, 'jhatkaGame']);


    Route::post('/update_jhatka_game',[JhatkaController::class , 'update_jhatka_game']);
});
