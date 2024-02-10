<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiceGameController extends Controller
{
    public function dice_game()
    {

        $orders = DB::table('dice_game_orders')->join('users', 'users.id', '=', 'dice_game_orders.user_id')->select('dice_game_orders.*', 'users.name', 'users.mobile')->orderBy('dice_game_orders.id','desc')->limit(1000)->get();
        return view('dice_game',  compact('orders'));
    }
}
