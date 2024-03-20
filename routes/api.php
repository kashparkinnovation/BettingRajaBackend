<?php

use App\Http\Controllers\DiceGameController;
use App\Http\Controllers\JhatkaController;
use App\Http\Controllers\RouletteController;
use App\Http\Controllers\SlotGameController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user_login',[UserController::class,'user_login']);
Route::post('/user_signup',[UserController::class,'user_signup']);
Route::get('/get_user_by_id',[UserController::class, 'getUserById']);
Route::get('/getUserBalance',[UserController::class, 'getUserBalance']);
Route::get('/getUserBonus',[UserController::class, 'getUserBonus']);
Route::get('/getOrderHistory',[UserController::class, 'getOrderHistory']);
Route::get('/getUserRechargeHistory',[UserController::class, 'getUserRechargeHistory']);
Route::get('/getUserWithdrawHistory',[UserController::class, 'getUserWithdrawHistory']);
Route::post('/rechargeRequest',[UserController::class, 'rechargeRequest']);
Route::post('/withdrawRequest',[UserController::class, 'withdrawRequest']);
Route::post('/addBankAccount',[UserController::class, 'addBankAccount']);
Route::get('/getBankAccounts',[UserController::class, 'getBankAccounts']);
Route::post('/playSlotGame',[SlotGameController::class, 'playSlotGame']);
Route::get('/getSlotGamePastSessions',[SlotGameController::class, 'getSlotGamePastSessions']);
Route::post('/playDiceGame',[DiceGameController::class, 'playDiceGame']);
Route::get('/getDiceGamePastSessions',[DiceGameController::class, 'getDiceGamePastSessions']);
Route::post('/playJhatkaGame',[JhatkaController::class, 'playJhatkaGame']);
Route::get('/getJhatkaGame',[JhatkaController::class, 'getJhatkaGame']);
Route::get('/getJhatkaGamePastOrders',[JhatkaController::class, 'getJhatkaGamePastOrders']);
Route::get('/getJhatkaGamePastSessions',[JhatkaController::class, 'getJhatkaGamePastSessions']);

Route::post('/playRouletteGame',[RouletteController::class, 'playRouletteGame']);
Route::get('/getrouletteGame',[RouletteController::class, 'getrouletteGame']);
Route::get('/getrouletteGamePastOrders',[RouletteController::class, 'getrouletteGamePastOrders']);
Route::get('/getrouletteGamePastSessions',[RouletteController::class, 'getrouletteGamePastSessions']);

Route::get('/getrouletteGameResult',[RouletteController::class, 'getrouletteGameResult']);