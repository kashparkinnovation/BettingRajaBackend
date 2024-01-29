<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            return 'User Insertion Failed!';
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
            $user = User::where('mobile', '=', $mobile)->get();
            if (count($user) > 0) {
                $pass = User::where('password', '=', $password)->get();
                if (count($pass) > 0) {
                    $result['status'] = 'OK';
                    $result['status_code'] = '200';
                    $result['message'] = 'Authorised User';
                } else {
                    $result['status'] = 'Failed';
                    $result['status_code'] = '300';
                    $result['message'] = 'Password is not correct';
                }
            } else {
                $result['status'] = 'Failed';
                $result['status_code'] = '301';
                $result['message'] = 'User Not Exist';
            }
        } catch (\Exception $e) {

            return 'Invalid Password';
        }

        return json_encode($result);
    }
}
