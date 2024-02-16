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
    $session_code = $sessiondate . "J" . $count;
    $start_at = date("Y-m-d H:i:s");
    $duration = '+2 minutes';
    $end_at = date('Y-m-d H:i:s', strtotime($duration, strtotime($start_at)));
    include 'connect.php';

    $result = mysqli_query($conn, "INSERT INTO `jhatka_session_data`(`session_code`, `start_at`, `end_at`) VALUES ('$session_code','$start_at', '$end_at')");
    $session_id = mysqli_insert_id($conn);
    $updateq = mysqli_query($conn, "UPDATE `jhatka_sessions_ids` SET `current_session`='$session_id' , `status`= 'Playing' WHERE `id` = 1");
    sleep(100);
    $updateq = mysqli_query($conn, "UPDATE `jhatka_sessions_ids` SET `status`= 'LockIn' WHERE `id` = 1");
    sleep(10);
    check_bets($session_id);
    sleep(10);
    $updateq = mysqli_query($conn, "UPDATE `jhatka_sessions_ids` SET `status`= 'Reloading' WHERE `id` = 1");
    sleep(20);
    $count++;
}
function check_bets($session_id)
{
    include 'connect.php';
    $amountquery = mysqli_query($conn, "SELECT SUM(`bid_amount`) as `bid_amount` ,`selected_no` FROM `jhatka_orders` WHERE `session_id` = '$session_id' GROUP BY `selected_no`");
    $bidarray = [];
    $result_no = 0;
    $payout = 0;
    $checkamount = [];
    $nos = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    shuffle($nos);
    if (mysqli_num_rows($amountquery) != 0) {
        while ($row = mysqli_fetch_array($amountquery)) {
            $test_no = intval($row['selected_no']);
            $test_amount = intval($row['bid_amount']);
            $totalamount += $test_amount;
            $bidarray[$test_no] = $test_amount;
        }
        $max_winnable_amount = 0.8 * $totalamount;
        for ($i = 0; $i <= 9; $i++) {
            if ($i == 0 || $i == 5) {
                $amount = 0;
                if (in_array($i, $bidarray)) {
                    $amount += intval($bidarray[$i]) * 5;
                    if (in_array(13, $bidarray)) {
                        $amount += intval($bidarray[13]) * 4;
                    }
                }
                $checkamount[$i] = $amount;
            } else if ($i == 1 || $i == 3 || $i == 7 || $i == 9) {
                $amount = 0;
                if (in_array($i, $bidarray)) {
                    $amount += intval($bidarray[$i]) * 5;
                    if (in_array(11, $bidarray)) {
                        $amount += intval($bidarray[11]) * 2;
                    }
                }
                $checkamount[$i] = $amount;
            } else if ($i == 2 || $i == 4 || $i == 6 || $i == 8) {
                $amount = 0;
                if (in_array(5, $bidarray)) {
                    $amount += intval($bidarray[5]) * 5;
                    if (in_array(12, $bidarray)) {
                        $amount += intval($bidarray[12]) * 2;
                    }
                }
                $checkamount[$i] = $amount;
            }
        }
        foreach ($nos as $no) {
            if ($checkamount[$no] <= $max_winnable_amount) {
                $result_no = $no;
                $payout = $checkamount[$no];
            }
        }
    } else {
        $payout = 0;
        $result_no = rand(0, 9);
    }
    mysqli_query($conn, "UPDATE `jhatka_session_data` SET `result`='$result_no',`amount`='$totalamount',`payout`='$payout' WHERE `id` = '$session_id'");
    $update_order_query = "";
    if ($result_no == 0 || $result_no == 5) {
        $update_order_query .= "UPDATE `jhatka_orders` SET `status`='WIN',`final_amount`=`bid_amount`*4 WHERE `session_id` = '$session_id' AND `selected_no` = '13';";
    } else {
        $update_order_query .= "UPDATE `jhatka_orders` SET `status`='LOSE',`final_amount`='0' WHERE `session_id` = '$session_id' AND ( `selected_no` = '11' OR `selected_no` = '12');";
    }
    if ($result_no == 1 || $result_no == 3 || $result_no == 7 || $result_no == 9) {
        $update_order_query .= "UPDATE `jhatka_orders` SET `status`='WIN',`final_amount`=`bid_amount`*2 WHERE `session_id` = '$session_id' AND `selected_no` = '12';";
    } else {
        $update_order_query .= "UPDATE `jhatka_orders` SET `status`='LOSE',`final_amount`='0' WHERE `session_id` = '$session_id' AND ( `selected_no` = '11' OR `selected_no` = '13');";
    }
    if ($result_no == 2 || $result_no == 4 || $result_no == 6 || $result_no == 8) {
        $update_order_query .= "UPDATE `jhatka_orders` SET `status`='WIN',`final_amount`=`bid_amount`*2 WHERE `session_id` = '$session_id' AND `selected_no` = '11';";
    } else {
        $update_order_query .= "UPDATE `jhatka_orders` SET `status`='LOSE',`final_amount`='0' WHERE `session_id` = '$session_id' AND ( `selected_no` = '12' OR `selected_no` = '13');";
    }
    for ($i = 0; $i <= 9; $i++) {
        if ($i == $result_no) {
            $update_order_query .= "UPDATE `jhatka_orders` SET `status`='WIN',`final_amount`=`bid_amount`*5 WHERE `session_id` = '$session_id' AND `selected_no` = '$i';";
        } else {
            $update_order_query .= "UPDATE `jhatka_orders` SET `status`='LOSE',`final_amount`='0' WHERE `session_id` = '$session_id' AND `selected_no` <> '$result_no';";
        }
    }
    mysqli_multi_query($conn, $update_order_query);
    $insert_query = "INSERT INTO `user_orders`(`user_id`, `game_type`, `game_session`, `amount`, `status`, `final_amount`) SELECT jhatka_orders.user_id , 'JHATKA' , jhatka_orders.session_id, jhatka_orders.bid_amount , jhatka_orders.status , jhatka_orders.final_amount FROM jhatka_orders WHERE jhatka_orders.session_id = $session_id;";
    mysqli_query($conn, $insert_query);
    $insert_query2 = "INSERT INTO `user_transactions`(`user_id`, `type`, `amount`, `game_type`, `session_id`) SELECT jhatka_orders.user_id , 'CREDIT' , jhatka_orders.bid_amount , 'JHATKA' ,jhatka_orders.session_id FROM jhatka_orders WHERE jhatka_orders.session_id = $session_id AND jhatka_orders.status='WIN';";
    mysqli_query($conn, $insert_query2);
}
