<?php
set_time_limit(0);
ignore_user_abort(true);
date_default_timezone_set("Asia/Kolkata");
$current_date = date("d");
$count = 1;


while (true) {
    if ($count >= 9999) {
        $count = 1;
    }
    $sessiondate = date("Ymd");
    $session_code = $sessiondate . "R" . $count;
    $start_at = date("Y-m-d H:i:s");
    $duration = '+1 minutes';
    $end_at = date('Y-m-d H:i:s', strtotime($duration, strtotime($start_at)));
    include 'connect.php';
    $result = mysqli_query($conn, "INSERT INTO `roulette_session_data`(`session_code`, `start_at`, `end_at`) VALUES ('$session_code','$start_at', '$end_at')");
    $session_id = mysqli_insert_id($conn);
    $updateq = mysqli_query($conn, "UPDATE `roulette_sessions_ids` SET `current_session`='$session_id' , `status`= 'Playing' WHERE `id` = 1");
    sleep(40);
    $updateq = mysqli_query($conn, "UPDATE `roulette_sessions_ids` SET `status`= 'LockIn' WHERE `id` = 1");
    sleep(10);
    include 'connect.php';
    $amountquery = mysqli_query($conn, "SELECT SUM(`bid_amount`) as `bid_amount` ,`selected_no` FROM `roulette_orders` WHERE `session_id` = '$session_id' GROUP BY `selected_no`");
    $game_settings  = mysqli_query($conn, "SELECT `win_percent` FROM `roulette_game_manage` WHERE `id`=1");
    $game_Sett = mysqli_fetch_assoc($game_settings);
    $win_percent = $game_Sett['win_percent'];
    $win_percentage = intval($win_percent) / 100;
    $bidarray = [];
    $result_no = 0;
    $payout = 0;
    $is_result_found = false;
    $totalamount = 0;
    $checkamount = [];
    $nos = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36];
    shuffle($nos);


    if (mysqli_num_rows($amountquery) != 0) {
        while ($row = mysqli_fetch_array($amountquery)) {
            $test_no = intval($row['selected_no']);
            $test_amount = intval($row['bid_amount']);
            $totalamount += $test_amount;
            $bidarray[$test_no] = $test_amount;
        }
        $max_winnable_amount = $win_percentage * $totalamount;

        for ($i = 0; $i <= 36; $i++) {
            if ($i == 0) {
                $amount = 0;
                if (array_key_exists($i, $bidarray)) {
                    $amount += intval($bidarray[$i]) * 10;
                }
                $checkamount[$i] = $amount;
            } else if ($i % 2 == 1) {
                $amount = 0;
                if (array_key_exists($i, $bidarray)) {
                    $amount += intval($bidarray[$i]) * 8;
                }
                if (array_key_exists(37, $bidarray)) {
                    $amount += intval($bidarray[37]) * 2;
                }
                if (array_key_exists(39, $bidarray)) {
                    $amount += intval($bidarray[39]) * 2;
                }
                $checkamount[$i] = $amount;
            } else if ($i % 2 == 0) {
                $amount = 0;
                if (array_key_exists($i, $bidarray)) {
                    $amount += intval($bidarray[$i]) * 8;
                }
                if (array_key_exists(38, $bidarray)) {
                    $amount += intval($bidarray[38]) * 2;
                }
                if (array_key_exists(40, $bidarray)) {
                    $amount += intval($bidarray[40]) * 2;
                }
                $checkamount[$i] = $amount;
            }
        }
        $minDifference = PHP_INT_MAX;
        foreach ($nos as $no) {
            if ($checkamount[$no] <= $max_winnable_amount) {
                $difference = abs($max_winnable_amount - $checkamount[$no]);
                if ($difference < $minDifference) {
                    $minDifference = $difference;
                    $result_no = $no;
                    $payout = $checkamount[$no];
                    $is_result_found = true;
                }
            }
        }
        if (!$is_result_found) {
            $payout = 0;
            $result_no = rand(0, 9);
        }
    } else {
        $payout = 0;
        $result_no = rand(0, 9);
    }

    mysqli_query($conn, "UPDATE `roulette_session_data` SET `result`='$result_no',`amount`='$totalamount',`payout`='$payout' WHERE `id` = '$session_id'");
    $update_order_query = "";
    if ($result_no == 0) {
        $update_order_query .= "UPDATE `roulette_orders` SET `status`='Win',`final_amount`=`bid_amount`*10 WHERE `session_id` = $session_id AND `selected_no` = 0;";
        $update_order_query .= "UPDATE `roulette_orders` SET `status`='Lose',`final_amount`='0' WHERE `session_id` = $session_id AND ( `selected_no` = 37 OR `selected_no` = 38 OR `selected_no` = 39 OR `selected_no` = 40 );";
    } else if ($result_no  % 2 == 0) {
        $update_order_query .= "UPDATE `roulette_orders` SET `status`='Win',`final_amount`=`bid_amount`*2 WHERE `session_id` = $session_id AND (`selected_no` = 38 OR `selected_no` = 40);";
        $update_order_query .= "UPDATE `roulette_orders` SET `status`='Lose',`final_amount`='0' WHERE `session_id` = $session_id AND ( `selected_no` = 39 OR `selected_no` = 37 OR `selected_no` = 0);";
    } else if ($result_no % 2 == 1) {
        $update_order_query .= "UPDATE `roulette_orders` SET `status`='Win',`final_amount`=`bid_amount`*2 WHERE `session_id` = $session_id AND (`selected_no` = 39 OR `selected_no` = 37)";
        $update_order_query .= "UPDATE `roulette_orders` SET `status`='Lose',`final_amount`='0' WHERE `session_id` = $session_id AND ( `selected_no` = 38 OR `selected_no` = 40 OR `selected_no` = 0 );";
    }
    $update_order_query .= "UPDATE `roulette_orders` SET `status`='Win',`final_amount`=`bid_amount`*8 WHERE `session_id` = $session_id AND `selected_no` = $result_no;";
    $update_order_query .= "UPDATE `roulette_orders` SET `status`='Lose',`final_amount`='0' WHERE `session_id` = $session_id AND `selected_no` <> $result_no AND `selected_no` <> 0 AND `selected_no` <> 37 AND `selected_no` <> 38 AND `selected_no` <> 39 AND `selected_no` <> 40 ;";
    mysqli_multi_query($conn, $update_order_query);
    sleep(5);
    include 'connect.php';
    $insert_query = "INSERT INTO `user_orders`(`user_id`, `game_type`, `game_session`, `amount`, `status`, `final_amount`) SELECT roulette_orders.user_id , 'Roulette' , roulette_orders.session_id, roulette_orders.bid_amount , roulette_orders.status , roulette_orders.final_amount FROM roulette_orders WHERE roulette_orders.session_id = $session_id;";
    mysqli_query($conn, $insert_query);
    $insert_query2 = "INSERT INTO `user_transactions`(`user_id`, `type`, `amount`, `game_type`, `session_id`) SELECT roulette_orders.user_id , 'Credit' , roulette_orders.final_amount , 'Roulette' ,roulette_orders.session_id FROM roulette_orders WHERE roulette_orders.session_id = $session_id AND roulette_orders.status='Win';";
    mysqli_query($conn, $insert_query2);
    sleep(5);
    include 'connect.php';
    $updateq = mysqli_query($conn, "UPDATE `roulette_sessions_ids` SET `status`= 'Reloading' WHERE `id` = 1");
    sleep(20);
    $count++;
}
