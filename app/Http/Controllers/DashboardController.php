<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){


        $data['withdraw_req'] = DB::table('withdrawls')->where('status', '=', 'Pending')->count();
        $data['recharge_req'] = DB::table('recharges')->where('status', '=', 'Pending')->count();
        $total_rech =  DB::table('recharges')->where('status', '=', 'Success')->sum('amount');
        $total_with =  DB::table('withdrawls')->where('status', '=', 'Success')->sum('amount');
        $data['current_balance'] = $total_rech-$total_with;
        date_default_timezone_set("Asia/Kolkata");
        $start_time = date("Y-m-d 00:00:00");
        $end_time = date("Y-m-d 23:59:59");
        $data['dice_game_orders'] = DB::table('dice_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->count();
        $data['dice_game_win_amount'] = round(DB::table('dice_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'Win')->sum('final_amount'),2);
        $data['dice_game_lose_amount'] = round(DB::table('dice_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'Lose')->sum('amount'),2);

        $data['jhatka_orders'] = DB::table('jhatka_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->count();
        $data['jhatka_orders_win_amount'] = round(DB::table('jhatka_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'WIN')->sum('final_amount'),2);
        $data['jhatka_orders_lose_amount'] = round(DB::table('jhatka_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'LOSE')->sum('bid_amount'),2);

        $data['slot_game_orders'] = DB::table('slot_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->count();
        $data['slot_game_win_amount'] = round(DB::table('slot_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'Win')->sum('final_amount'),2);
        $data['slot_game_lose_amount'] = round(DB::table('slot_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'Lose')->sum('amount'),2);

        $data['dice_game_orders'] = DB::table('dice_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->count();
        $data['dice_game_win_amount'] = round(DB::table('dice_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'Win')->sum('final_amount'),2);
        $data['dice_game_lose_amount'] = round(DB::table('dice_game_orders')->whereBetween('playing_datetime', [$start_time,$end_time])->where('status', '=', 'Lose')->sum('amount'),2);
        return view('dashboard', compact('data'));
    }
}
