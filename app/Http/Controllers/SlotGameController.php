<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
class SlotGameController
{
    public function spinWheels()
    {
        // Define probabilities
        $probabilities = [
            'one_wheel' => 0.5,
            'two_wheels' => 0.06,
            'three_wheels' => 0.04,
            'no_wheels' => 0.4,
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
