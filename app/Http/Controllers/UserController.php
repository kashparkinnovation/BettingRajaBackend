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

    // public function user_login(Request $request){
    //     $mobile = $request->mobile;
    //     $password = $request->mobile;
    //     try {
    //         if (User::attempt($user_Login)) {
    //             $user = User::user();
    //             $result['status'] = 'Ok';
    //             $result['status_code'] = '200';
    //             $result['message'] = 'User Login Successful';
    //             $result['user'] = $user;
    //         } else {
    //             $result['status'] = 'Failed';
    //             $result['status_code'] = '300';
    //             $result['message'] = 'Unauthorized';
    //         }
    //     } catch (\Exception $e) {
    //         return "User Not Signup";
    //     }

    //     return json_encode($result);

    // }


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
}
