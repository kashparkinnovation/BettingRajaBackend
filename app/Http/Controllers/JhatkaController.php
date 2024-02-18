<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JhatkaController extends Controller
{

    public function jhatkaGame(){

        $data = DB::table('jhatka_game_manage')->where('id', '=', 1)->get()[0];
        $orders = DB::table('jhatka_orders')->join('users', 'users.id', '=', 'jhatka_orders.user_id')->join('jhatka_session_data', 'jhatka_session_data.id', '=', 'jhatka_orders.session_id')->select('jhatka_orders.*','jhatka_session_data.session_code', 'users.name', 'users.mobile')->orderBy('jhatka_orders.id', 'desc')->limit(1000)->get();
        return view('jhatkagame', compact('data'), compact('orders'));

    }
    public function playJhatkaGame(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $number = $request->get('num');
        $session_data = DB::table('jhatka_sessions_ids')->first();
        if ($session_data->status == "Playing") {
            $session_id = $session_data->current_session;
            date_default_timezone_set("Asia/Kolkata");
            $start_time = date("Y-m-d h:i:s");
            $order = ["user_id" => $user_id, "bid_amount" => $amount, "selected_no" => $number, "session_id" => $session_id, ""];
            DB::table('jhatka_orders')->insert($order);
            $tranx = ["user_id" => $user_id, "type" => "Debit",  "amount" => $amount, "game_type" => "JHATKA", "session_id" => $session_id];
            DB::table('user_transactions')->insert($tranx);
            $result = ["status" => "Success", "status_code" => "200", "msg" => "Bid Placed Successfully!"];
        } else {
            $result = ["status" => "Failed", "status_code" => "300", "msg" => "Bid Placing Time Out. Play In New Session!"];
        }
        return json_encode($result);
    }
    public function update_jhatka_game(Request $request){
        $win_percent = $request->get('win_percent');
        $data = ['win_percent' => $win_percent];
        DB::table('jhatka_game_manage')->where('id', 1)->update($data);
        return redirect('/jhatkaGame');
    }
    public function getJhatkaGame()
    {
        $result = DB::table('jhatka_sessions_ids')->join('jhatka_session_data', 'jhatka_session_data.id', '=', 'jhatka_sessions_ids.current_session')->select('jhatka_session_data.id', 'jhatka_session_data.session_code', 'jhatka_session_data.start_at', 'jhatka_session_data.end_at', 'jhatka_sessions_ids.status')->where('jhatka_sessions_ids.id', '=', '1')->get()[0];
        $last_id = $result->id - 1;
        $result->last_game = DB::table('jhatka_session_data')->select('jhatka_session_data.id', 'jhatka_session_data.session_code', 'jhatka_session_data.result')->where('jhatka_session_data.id', '=', $last_id)->get()[0];

        return json_encode($result);
    }
    public function getJhatkaGamePastSessions()
    {
        $result = DB::table('jhatka_sessions_ids')->where('jhatka_sessions_ids.id', '=', '1')->get()[0];
        $last_id = $result->current_session;

        $result = DB::table('jhatka_session_data')->select('jhatka_session_data.id', 'jhatka_session_data.session_code', 'jhatka_session_data.result')->where('id', '!=', $last_id)->orderBy('id', 'Desc')->limit(10)->get();
        return json_encode($result);
    }

    public function getJhatkaGamePastOrders(Request $request)
    {$result = DB::table('jhatka_sessions_ids')->where('jhatka_sessions_ids.id', '=', '1')->get()[0];
        $last_id = $result->current_session;
        $user_id = $request->id;
        $result = DB::table('jhatka_orders')->where('jhatka_orders.user_id', '=', $user_id)->where('session_id', '!=', $last_id)->get();
         return json_encode($result);
    }
}
