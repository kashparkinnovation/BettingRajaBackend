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
    public function playDiceGame(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $number = $request->get('num');
        $roll = $request->get('roll');
        $result_num = [];
        $winmsg = "";


        $first_num = mt_rand(0, 9);
        $second_num = mt_rand(0, 9);
        $third_num = mt_rand(0, 9);
        $forth_num = mt_rand(0, 9);
        array_push($result_num,$first_num);
        array_push($result_num,$second_num);
        array_push($result_num,$third_num);
        array_push($result_num,$forth_num);
        $final_num = $first_num * 1000 + $second_num *100 + $third_num * 10 + $forth_num;
        $ref_num = intval($number);

        $percent = 0;
        if ($roll == "0") {
          $percent =  $ref_num / 100;
        } else {
          $percent = (10000 - $ref_num) / 100;
        }
        $payout = (100/$percent) - (0.02 * (100/$percent));
        $final_amount = $amount * $payout; 
        if($roll == "0"){
             if($final_num <= $ref_num){


                $winmsg = "WIN";
                $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $final_amount, "status" => "Win"];
                $session_id = DB::table('dice_game_orders')->insertGetId($order);
                $game_data = ["user_id" => $user_id, "game_type" => "Dice Game", "game_session" => $session_id, "amount" => $amount, "status" => "Win", "final_amount" => $final_amount];
                DB::table('user_orders')->insert($game_data);
                $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Dice Game", "session_id" => $session_id];
                DB::table('user_transactions')->insert($trans_debit_data);
                $trans_credit_data = ["user_id" => $user_id, "type" => "Credit", "amount" => $final_amount, "game_type" => "Dice Game", "session_id" => $session_id];
                DB::table('user_transactions')->insert($trans_credit_data);
    
            }else{
                $winmsg = "Lose";
                $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => "0", "status" => "Lose"];
                $session_id = DB::table('dice_game_orders')->insertGetId($order);
                $game_data = ["user_id" => $user_id, "game_type" => "Dice Game", "game_session" => $session_id, "amount" => $amount, "status" => "Lose", "final_amount" => "0"];
                DB::table('user_orders')->insert($game_data);
                $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Dice Game", "session_id" => $session_id];
                DB::table('user_transactions')->insert($trans_debit_data);               
            }
        }else{
            if($final_num > $ref_num){
                $winmsg = "WIN";
                $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $final_amount, "status" => "Win"];
                $session_id = DB::table('dice_game_orders')->insertGetId($order);
                $game_data = ["user_id" => $user_id, "game_type" => "Dice Game", "game_session" => $session_id, "amount" => $amount, "status" => "Win", "final_amount" => $final_amount];
                DB::table('user_orders')->insert($game_data);
                $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Dice Game", "session_id" => $session_id];
                DB::table('user_transactions')->insert($trans_debit_data);
                $trans_credit_data = ["user_id" => $user_id, "type" => "Credit", "amount" => $final_amount, "game_type" => "Dice Game", "session_id" => $session_id];
                DB::table('user_transactions')->insert($trans_credit_data);
    
            }else{
                $winmsg = "Lose";
                $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => "0", "status" => "Lose"];
                $session_id = DB::table('dice_game_orders')->insertGetId($order);
                $game_data = ["user_id" => $user_id, "game_type" => "Dice Game", "game_session" => $session_id, "amount" => $amount, "status" => "Lose", "final_amount" => "0"];
                DB::table('user_orders')->insert($game_data);
                $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Dice Game", "session_id" => $session_id];
                DB::table('user_transactions')->insert($trans_debit_data);
            }
        }
   
        $result = ["status" => "Success", "status_code" => "200","msg"=>$winmsg, "result" => $result_num];
        return json_encode($result);
    }
   
 
}
