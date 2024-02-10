<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlotGameController
{
    public function slot_game()
    {
        $data = DB::table('slot_games')->where('id', '=', 1)->get()[0];
        $orders = DB::table('slot_game_orders')->join('users', 'users.id', '=', 'slot_game_orders.user_id')->select('slot_game_orders.*', 'users.name', 'users.mobile')->orderBy('slot_game_orders.id','desc')->limit(1000)->get();
        return view('slotgame', compact('data'), compact('orders'));
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
            'one_wheel' => $data->single_number_chance/100,
            'two_wheels' => $data->double_number_chance/100,
            'three_wheels' => $data->jackpot_number_chance/100,
            'no_wheels' => $data->loosing_number_chance/100,
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
