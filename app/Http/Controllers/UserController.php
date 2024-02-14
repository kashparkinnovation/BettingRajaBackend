<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function user_signup(Request $request)
    {
        $newUser = new User;
        $newUser->name = $request->get('name');
        $newUser->mobile = $request->get('mobile');
        $newUser->password = $request->get('password');
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
        $user = DB::table('users')->select('name', 'mobile', 'id', 'status')->where('id', '=', $id)->get()[0];

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
        $result['balance'] = "".$balance;
        
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
        return json_encode($result);
    }
    public function withdrawRequest(Request $request)
    {
        $user_id = $request->get('user_id');
        $amount = $request->get('amount');
        $bank_id = $request->get('bank_id');
        $data = ['user_id' => $user_id, 'amount' => $amount, 'bank_id' => $bank_id];
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
        return json_encode($result);
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
}
