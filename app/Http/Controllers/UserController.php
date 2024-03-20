<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;


use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function user_signup(Request $request)
    {
        $newUser = new User;
        $name = $request->get('name');
        $newUser->mobile = $request->get('mobile');
        $newUser->password = $request->get('password');
        $refer_code = $request->get('refer_code');
        $newUser->name = $name;
        $nameCode = Str::upper(substr($name, 0, 2));
        $now = Carbon::now();
        $dateTimeCode = $now->format('YmdHis');
        $my_refer_code = $nameCode . $dateTimeCode;
        $newUser->refer_code = $my_refer_code;


        if (Str::startsWith($refer_code, 'V-')) {
           $refer_vendor = DB::table('vendors')->where('vendor_code', $refer_code)->get();
           if(count($refer_vendor) > 0 ){
            $newUser->vendor_id = $refer_vendor[0]->id;
           }
        } else { 
        $refer_user = DB::table('users')->where('refer_code', $refer_code)->get();
        if (count($refer_user) == 1) {
            $user_id = $refer_user[0]->id;
            if($refer_user[0]->vendor_id != 0){
                $newUser->vendor_id = $refer_user[0]->vendor_id;
            }else{
                $newUser->vendor_id = 0;
            }
            $newUser->refered_by = $user_id;
        } else {
            $newUser->refered_by = 0;
        }
    }
        try {
            if ($newUser->save()) {
                $id = $newUser->getKey();
                $result['status'] = 'Ok';
                $result['status_code'] = '200';
                $result['message'] = 'User Inserted Successully!';
                $result['inserted_id'] = $id;
            } else {
                $result['status'] = 'Failed';
                $result['status_code'] = '300';
                $result['message'] = 'User Insertion Failed!';
                $result['inserted_id'] = 0;
            }
        } catch (\Exception $e) {
            $result['status'] = 'Failed';
            $result['status_code'] = '300';
            $result['message'] = 'User Insertion Failed!';
            $result['inserted_id'] = 0;
        }
        return json_encode($result);
    }




    public function user_login(Request $request)
    {
        $mobile = $request->mobile;
        $password = $request->password;

        try {
            $user = User::where('password', '=', $password)->where('mobile', '=', $mobile)->get();
            if (count($user) == 1) {
                if ($user[0]->status == 'Active') {
                    $result['status'] = 'OK';
                    $result['status_code'] = '200';
                    $result['message'] = 'Authorised User';
                    $result['user_id'] = $user[0]->id;
                } else {
                    $result['status'] = 'Failed';
                    $result['status_code'] = '300';
                    $result['message'] = 'Account Inactive';
                    $result['user_id'] = 0;
                }
            } else {
                $result['status'] = 'Failed';
                $result['status_code'] = '301';
                $result['message'] = 'Invalid Credentials';
                $result['user_id'] = 0;
            }
        } catch (\Exception $e) {

            $result['status'] = 'Failed';
            $result['status_code'] = '301';
            $result['message'] = 'Invalid Credentials';
            $result['user_id'] = 0;
        }

        return json_encode($result);
    }
    public function getUser(Request $request)
    {
        $users = User::all();
        return view('user', compact('users'));
    }
    public function getUserById(Request $request)
    {
        $id = $request->get('id');
        $user = DB::table('users')->select('name', 'mobile', 'refer_code', 'id', 'status')->where('id', '=', $id)->get()[0];

        return json_encode($user);
    }

    public function users_status_update(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        try {
            $user = User::find($id);
            $user->status = $status;
            if ($user->save()) {
                return response()->json(['success' => 'User status change successfully.']);
            } else {
                return response()->json(['failed' => 'User status change failed.']);
            }
        } catch (\Exception $e) {
            return response()->json(['failed' => $e]);
        }
    }
    public function getUserBalance(Request $request)
    {
        $id = $request->id;
        $credit = DB::table('user_transactions')->where('type', '=', 'Credit')->where('user_id', '=', $id)->sum('amount');
        $debit = DB::table('user_transactions')->where('type', '=', 'Debit')->where('user_id', '=', $id)->sum('amount');
        $balance =  $credit - $debit;

        $result['status'] = 'Success';
        $result['status_code'] = '200';
        $result['message'] = 'Balance Fetched';
        $result['balance'] = "" . $balance;

        return json_encode($result);
    }
    public function getUserBonus(Request $request)
    {
        $id = $request->id;
        $c_bonus = DB::table('users')->where('id', $id)->get()[0]->bonus;
        $result['status'] = 'Success';
        $result['status_code'] = '200';
        $result['message'] = 'Bonus Fetched';
        $result['balance'] = "" . $c_bonus;

        return json_encode($result);
    }

    public function getOrderHistory(Request $request)
    {
        $id = $request->id;
        $orders = DB::table('user_orders')->where('user_id', $id)->orderBy('id', 'Desc')->limit(200)->get();
        return json_encode($orders);
    }
    public function getUserRechargeHistory(Request $request)
    {
        $id = $request->id;
        $data = DB::table('recharges')->where('user_id', $id)->orderBy('id', 'Desc')->get();
        return json_encode($data);
    }
    public function getUserWithdrawHistory(Request $request)
    {
        $id = $request->id;
        $data = DB::table('withdrawls')->where('user_id', $id)->orderBy('id', 'Desc')->get();
        return json_encode($data);
    }
    public function rechargeRequest(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $check = DB::table('recharges')->where('user_id', $user_id)->where('status', 'Pending')->get();
        if (count($check) == 0) {
            $data = ['user_id' => $user_id, 'amount' => $amount];
            try {
                DB::table('recharges')->insert($data);
                $result['status'] = 'Success';
                $result['status_code'] = '200';
                $result['message'] = 'Request Submitted';
            } catch (\Exception $e) {

                $result['status'] = 'Failed';
                $result['status_code'] = '300';
                $result['message'] = 'Request Failed';
            }
        } else {
            $result['status'] = 'Failed';
            $result['status_code'] = '400';
            $result['message'] = 'One Pending Request Already Exist!';
        }
        return json_encode($result);
    }
    public function withdrawRequest(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $bank_id = $request->get('bank_id');
        $data = ['user_id' => $user_id, 'amount' => $amount, 'bank_id' => $bank_id];
        $check = DB::table('withdrawls')->where('user_id', $user_id)->where('status', 'Pending')->get();
        if (count($check) == 0) {
            try {
                DB::table('withdrawls')->insert($data);
                $result['status'] = 'Success';
                $result['status_code'] = '200';
                $result['message'] = 'Request Submitted';
            } catch (\Exception $e) {
                $result['status'] = 'Failed';
                $result['status_code'] = '300';
                $result['message'] = 'Request Failed';
            }
        } else {
            $result['status'] = 'Failed';
            $result['status_code'] = '400';
            $result['message'] = 'One Pending Request Already Exist!';
        }
        return json_encode($result);
    }
    public function getBankAccounts(Request $request)
    {
        $user_id = $request->get('user_id');
        $banks =  DB::table('user_banks')->where('user_id', $user_id)->get();
        return json_encode($banks);
    }
    public function addBankAccount(Request $request)
    {
        $user_id = $request->get('user_id');
        $name = $request->get('name');
        $ifsc = $request->get('ifsc');
        $ac_no = $request->get('ac_no');
        $ac_holder = $request->get('ac_holder');
        $data = ['user_id' => $user_id, 'name' => $name, 'ifsc' => $ifsc, 'ac_holder' => $ac_holder, 'ac_no' => $ac_no];
        try {
            DB::table('user_banks')->insert($data);
            $result['status'] = 'Success';
            $result['status_code'] = '200';
            $result['message'] = 'Bank Addedd';
        } catch (\Exception $e) {
            $result['status'] = 'Failed';
            $result['status_code'] = '300';
            $result['message'] = 'Bank Add Failed';
        }
        return json_encode($result);
    }
    public function withdrawReq(Request $request)
    {
        $data = DB::table('withdrawls')->join('users', 'users.id', '=', 'withdrawls.user_id')->join('user_banks', 'user_banks.id', 'withdrawls.bank_id')->select('withdrawls.*', 'users.name', 'users.mobile', 'user_banks.name as bank_name', 'user_banks.ifsc', 'user_banks.ac_no', 'user_banks.ac_holder')->orderBy('id', 'Desc')->get();

        return view('withdrawReq', compact('data'));
    }
    public function UpdateWithdrawReq(Request $request)
    {
        $id = $request->get('id');
        $data = DB::table('withdrawls')->where('id', $id)->first();
        $amount = $data->amount;
        $user_id = $data->user_id;

        $trans_credit_data = ["user_id" => $user_id, "type" => "Debit", "amount" => $amount, "game_type" => "Withdraw", "session_id" => $id];
        DB::table('user_transactions')->insert($trans_credit_data);
        $updateData = ['status' => 'Success'];
        DB::table('withdrawls')->where('id', $id)->update($updateData);
        return redirect('/withdrawReq');
    }
    public function cancelWithdrawReq(Request $request)
    {
        $id = $request->get('id');
        $updateData = ['status' => 'Failed'];
        DB::table('withdrawls')->where('id', $id)->update($updateData);
        return redirect('/withdrawReq');
    }

    public function rechargeReq(Request $request)
    {
        $data = DB::table('recharges')->join('users', 'users.id', '=', 'recharges.user_id')->select('recharges.*', 'users.name', 'users.mobile')->orderBy('id', 'Desc')->get();

        return view('rechargeReq', compact('data'));
    }
    public function UpdaterechargeReq(Request $request)
    {
        $id = $request->get('id');
        $data = DB::table('recharges')->where('id', $id)->first();
        $amount = $data->amount;
        $user_id = $data->user_id;
        $trans_credit_data = ["user_id" => $user_id, "type" => "Credit", "amount" => $amount, "game_type" => "Recharge", "session_id" => $id];
        DB::table('user_transactions')->insert($trans_credit_data);
        $updateData = ['status' => 'Success'];
        DB::table('recharges')->where('id', $id)->update($updateData);


        $count = DB::table('recharges')->where('user_id', $user_id)->where('status', 'Success')->get();
        if (count($count) == 1) {
            $refered_by = DB::table('users')->where('id', $user_id)->get()[0];
            if ($refered_by->refered_by != 0) {
                $referrer =  $refered_by->refered_by;
                $c_bonus = DB::table('users')->where('id', $referrer)->get()[0]->bonus;
                if ($amount <= 200) {
                    $n_bonus = $amount;
                } else {
                    $n_bonus = 200;
                }
                $bonus = $c_bonus + $n_bonus;
                $b_updateData = ['bonus' => $bonus];
                DB::table('users')->where('id', $referrer)->update($b_updateData);
            }
        }
        return redirect('/rechargeReq');
    }
    public function cancelrechargeReq(Request $request)
    {
        $id = $request->get('id');
        $updateData = ['status' => 'Failed'];
        DB::table('recharges')->where('id', $id)->update($updateData);
        return redirect('/rechargeReq');
    }
    public function fetch_rec_with_req_count()
    {
        $rech = DB::table('recharges')->where('status', 'Pending')->get()->count();
        $with = DB::table('withdrawls')->where('status', 'Pending')->get()->count();
        $data = [
            'rech' => $rech,
            'with' => $with
        ];
        return json_encode($data);
    }
}
