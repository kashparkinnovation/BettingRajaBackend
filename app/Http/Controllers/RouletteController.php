<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouletteController extends Controller
{
    
    public function rouletteGame(){

        $data = DB::table('roulette_game_manage')->where('id', '=', 1)->get()[0];
        $orders = DB::table('roulette_orders')->join('users', 'users.id', '=', 'roulette_orders.user_id')->join('roulette_session_data', 'roulette_session_data.id', '=', 'roulette_orders.session_id')->select('roulette_orders.*','roulette_session_data.session_code', 'users.name', 'users.mobile')->orderBy('roulette_orders.id', 'desc')->limit(1000)->get();
        return view('roulettegame', compact('data'), compact('orders'));

    }
    public function playRouletteGame(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $number = $request->get('num');
        $session_data = DB::table('roulette_sessions_ids')->first();
        if ($session_data->status == "Playing") {
            $session_id = $session_data->current_session;
            date_default_timezone_set("Asia/Kolkata");
            $start_time = date("Y-m-d h:i:s");
            $order = ["user_id" => $user_id, "bid_amount" => $amount, "selected_no" => $number, "session_id" => $session_id];
            DB::table('roulette_orders')->insert($order);
            $tranx = ["user_id" => $user_id, "type" => "Debit",  "amount" => $amount, "game_type" => "Roulette", "session_id" => $session_id];
            DB::table('user_transactions')->insert($tranx);
            $result = ["status" => "Success", "status_code" => "200", "msg" => "Bet Placed Successfully!"];
        } else {
            $result = ["status" => "Failed", "status_code" => "300", "msg" => "Bet Placing Time Out. Play In New Session!"];
        }
        return json_encode($result);
    }
    public function update_roulette_game(Request $request){
        $win_percent = $request->get('win_percent');
        $data = ['win_percent' => $win_percent];
        DB::table('roulette_game_manage')->where('id', 1)->update($data);
        return redirect('/rouletteGame');
    }
    public function getrouletteGame()
    {
        $result = DB::table('roulette_sessions_ids')->join('roulette_session_data', 'roulette_session_data.id', '=', 'roulette_sessions_ids.current_session')->select('roulette_session_data.id', 'roulette_session_data.session_code', 'roulette_session_data.start_at', 'roulette_session_data.end_at', 'roulette_sessions_ids.status')->where('roulette_sessions_ids.id', '=', '1')->get()[0];
        $last_id = $result->id - 1;
        $result->last_game = DB::table('roulette_session_data')->select('roulette_session_data.id', 'roulette_session_data.session_code', 'roulette_session_data.result')->where('roulette_session_data.id', '=', $last_id)->get()[0];

        return json_encode($result);
    }
    public function getrouletteGameResult()
    {
        $last_id = DB::table('roulette_sessions_ids')->join('roulette_session_data', 'roulette_session_data.id', '=', 'roulette_sessions_ids.current_session')->select('roulette_session_data.id', 'roulette_session_data.session_code', 'roulette_session_data.start_at', 'roulette_session_data.end_at', 'roulette_sessions_ids.status')->where('roulette_sessions_ids.id', '=', '1')->get()[0]->last_id;
        $result = DB::table('roulette_session_data')->select('roulette_session_data.id', 'roulette_session_data.session_code', 'roulette_session_data.result')->where('roulette_session_data.id', '=', $last_id)->get()[0];
        return json_encode($result);
    }
    
    public function getrouletteGamePastSessions()
    {
        $result = DB::table('roulette_sessions_ids')->where('roulette_sessions_ids.id', '=', '1')->get()[0];
        $last_id = $result->current_session;

        $result = DB::table('roulette_session_data')->select('roulette_session_data.id', 'roulette_session_data.session_code', 'roulette_session_data.result')->where('id', '!=', $last_id)->orderBy('id', 'Desc')->limit(10)->get();
        return json_encode($result);
    }

    public function getrouletteGamePastOrders(Request $request)
    {
        $result = DB::table('roulette_sessions_ids')->where('roulette_sessions_ids.id', '=', '1')->get()[0];
        $last_id = $result->current_session;
        $user_id = $request->id;
        $result = DB::table('roulette_orders')->where('roulette_orders.user_id', '=', $user_id)->where('session_id', '!=', $last_id)->get();
         return json_encode($result);
    }
}
