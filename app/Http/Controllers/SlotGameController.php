<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Floats;

class SlotGameController
{
    public function slot_game()
    {
        $data = DB::table('slot_games')->where('id', '=', 1)->get()[0];
        $orders = DB::table('slot_game_orders')->join('users', 'users.id', '=', 'slot_game_orders.user_id')->select('slot_game_orders.*', 'users.name', 'users.mobile')->orderBy('slot_game_orders.id', 'desc')->limit(1000)->get();
        return view('slotgame', compact('data'), compact('orders'));
    }
    public function playSlotGame(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $number = $request->get('num');
        $result_num = [];
        $winmsg = "";
        $data = DB::table('slot_games')->where('id', '=', 1)->get()[0];
        // Define probabilities
        $probabilities = [
            'one_wheel' => $data->single_number_chance / 100,
            'two_wheels' => $data->double_number_chance / 100,
            'three_wheels' => $data->jackpot_number_chance / 100,
            'no_wheels' => $data->loosing_number_chance / 100,
        ];

        // Generate a random number to determine the outcome
        $randomNumber = mt_rand(1, 100) / 100;

        // Check the outcome based on probabilities
        if ($randomNumber <= $probabilities['one_wheel']) {
            $correct_num_pos = mt_rand(1, 3);
            $winmsg = "WIN";
            for ($i = 1; $i < 4; $i++) {
                if ($correct_num_pos == $i) {
                    array_push($result_num, intval($number));
                } else {
                    while (true) {
                        $num1 = mt_rand(1, 9);
                        if ($num1 !=  intval($number)) {
                            array_push($result_num, $num1);
                            break;
                        }
                    }
                }
            }
            $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $amount, "status" => "Win"];
            $session_id = DB::table('slot_game_orders')->insertGetId($order);
            $game_data = ["user_id" => $user_id, "game_type" => "Slot Machine", "game_session" => $session_id, "amount" => $amount, "status" => "Win", "final_amount" => $amount];
            DB::table('user_orders')->insert($game_data);
            $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Slot Machine", "session_id" => $session_id];
            DB::table('user_transactions')->insert($trans_debit_data);
            $trans_credit_data = ["user_id" => $user_id, "type" => "Credit", "amount" => $amount, "game_type" => "Slot Machine", "session_id" => $session_id];
            DB::table('user_transactions')->insert($trans_credit_data);
        } elseif ($randomNumber <= ($probabilities['one_wheel'] + $probabilities['two_wheels'])) {
            $winmsg = "BIG WIN";
            $incorrect_num_pos = mt_rand(1, 3);
            for ($i = 1; $i < 4; $i++) {
                if ($incorrect_num_pos == $i) {
                    while (true) {
                        $num1 = mt_rand(1, 9);
                        if ($num1 !=  intval($number)) {
                            array_push($result_num, $num1);
                            break;
                        }
                    }
                } else {
                    array_push($result_num,  intval($number));
                }
            }
            $final_amount = floatval($amount) * 2;
            $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" =>  $final_amount, "status" => "Win"];
            DB::table('slot_game_orders')->insert($order);
            $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $final_amount, "status" => "Win"];
            $session_id = DB::table('slot_game_orders')->insertGetId($order);
            $game_data = ["user_id" => $user_id, "game_type" => "Slot Machine", "game_session" => $session_id, "amount" => $amount, "status" => "Win", "final_amount" => $final_amount];
            DB::table('user_orders')->insert($game_data);
            $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Slot Machine", "session_id" => $session_id];
            DB::table('user_transactions')->insert($trans_debit_data);
            $trans_credit_data = ["user_id" => $user_id, "type" => "Credit", "amount" => $final_amount, "game_type" => "Slot Machine", "session_id" => $session_id];
            DB::table('user_transactions')->insert($trans_credit_data);
        } elseif ($randomNumber <= ($probabilities['one_wheel'] + $probabilities['two_wheels'] + $probabilities['three_wheels'])) {
            $winmsg = "JACKPOT";
            for ($i = 1; $i < 4; $i++) {
                array_push($result_num,  intval($number));
            }
            $final_amount = floatval($amount) * 4;
            $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $final_amount, "status" => "Win"];
            DB::table('slot_game_orders')->insert($order);
            $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $final_amount, "status" => "Win"];
            $session_id = DB::table('slot_game_orders')->insertGetId($order);
            $game_data = ["user_id" => $user_id, "game_type" => "Slot Machine", "game_session" => $session_id, "amount" => $amount, "status" => "Win", "final_amount" => $final_amount];
            DB::table('user_orders')->insert($game_data);
            $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Slot Machine", "session_id" => $session_id];
            DB::table('user_transactions')->insert($trans_debit_data);
            $trans_credit_data = ["user_id" => $user_id, "type" => "Credit", "amount" => $final_amount, "game_type" => "Slot Machine", "session_id" => $session_id];
            DB::table('user_transactions')->insert($trans_credit_data);
        } else {
            $winmsg = "LOSE";
            for ($i = 1; $i < 4; $i++) {
                while (true) {
                    $num1 = mt_rand(1, 9);
                    if ($num1 !=  intval($number)) {
                        array_push($result_num, $num1);
                        break;
                    }
                }
            }
            $final_amount = 0;
            $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $final_amount, "status" => "Lose"];
            DB::table('slot_game_orders')->insert($order);
            $order = ["user_id" => $user_id, "amount" => $amount, "final_amount" => $final_amount, "status" => "Lose"];
            $session_id = DB::table('slot_game_orders')->insertGetId($order);
            $game_data = ["user_id" => $user_id, "game_type" => "Slot Machine", "game_session" => $session_id, "amount" => $amount, "status" => "Lose", "final_amount" => $final_amount];
            DB::table('user_orders')->insert($game_data);
            $trans_debit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Slot Machine", "session_id" => $session_id];
            DB::table('user_transactions')->insert($trans_debit_data);
        }
        $result = ["status" => "Success", "status_code" => "200","msg"=>$winmsg, "result" => $result_num];
        return json_encode($result);
    }
    public function update_slot_game(Request $request)
    {
        $single_number_chance = $request->get('one_chance');
        $double_number_chance = $request->get('two_chance');
        $jackpot_number_chance = $request->get('three_chance');
        $loosing_number_chance = $request->get('lose_chance');
        $data = ['single_number_chance' => $single_number_chance, 'double_number_chance' => $double_number_chance, 'jackpot_number_chance' => $jackpot_number_chance, 'loosing_number_chance' => $loosing_number_chance];
        DB::table('slot_games')->where('id', 1)->update($data);
        return redirect('/slot_game');
    }

    public function spinWheels()
    {
        $data = DB::table('slot_games')->where('id', '=', 1)->get()[0];
        // Define probabilities
        $probabilities = [
            'one_wheel' => $data->single_number_chance / 100,
            'two_wheels' => $data->double_number_chance / 100,
            'three_wheels' => $data->jackpot_number_chance / 100,
            'no_wheels' => $data->loosing_number_chance / 100,
        ];

        // Generate a random number to determine the outcome
        $randomNumber = mt_rand(1, 100) / 100;

        // Check the outcome based on probabilities
        if ($randomNumber <= $probabilities['one_wheel']) {
            return 1; // One wheel with 7
        } elseif ($randomNumber <= ($probabilities['one_wheel'] + $probabilities['two_wheels'])) {
            return 2; // Two wheels with 7
        } elseif ($randomNumber <= ($probabilities['one_wheel'] + $probabilities['two_wheels'] + $probabilities['three_wheels'])) {
            return 3; // Three wheels with 7
        } else {
            return 0; // No wheels with 7
        }
    }

    public function checkJackpot()
    {
        // Spin the wheels
        $result = $this->spinWheels();

        // Check if it's a jackpot
        return $result >= 2; // Two or three wheels with 7 is a jackpot
    }
}
