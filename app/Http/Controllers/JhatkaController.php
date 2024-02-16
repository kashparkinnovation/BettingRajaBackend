<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JhatkaController extends Controller
{
    public function playJhatkaGame(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $number = $request->get('num');
        $session_data = DB::table('jhatka_sessions_ids')->first();
        if ($session_data->status == "Playing") {
            $session_id = $session_data->current_session;
            $order = ["user_id" => $user_id, "bid_amount" => $amount, "selected_no" => $number, "session_id" => $session_id];
            DB::table('jhatka_orders')->insert($order);
            $tranx = ["user_id"=>$user_id,"type"=>"Debit",  "amount" => $amount, "game_type"=>"JHATKA", "session_id"=>$session_id];
            DB::table('user_transactions')->insert($tranx);
            $result = ["status" => "Success", "status_code" => "200", "msg" => "Bid Placed Successfully!"];
        }else{
            $result = ["status" => "Failed", "status_code" => "300", "msg" => "Bid Placing Time Out. Play In New Session!"];
        }
       return json_encode($result);
    }
    public function getJhatkaGame(){
        $current_game = DB::table('jhatka_sessions_ids')->join('jhatka_session_data','jhatka_session_data.id' , '=' , 'jhatka_sessions_ids.current_session' )->select('jhatka_session_data.*', 'jhatka_sessions_ids.status')->where('jhatka_sessions_ids.id', '=', '1')->get()[0];
        return json_encode($current_game);
    }
}
