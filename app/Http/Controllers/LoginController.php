<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function checkAuth(Request $request)
    {
        if ($request->session()->get('key')) {
            return redirect('/dashboard');
        } else {
            return redirect('/login');
        }
    }
    public function loginfunc(Request $request)
    {
        $uname = $request->post('username');
        $pass = $request->post('password');
        $usercount = DB::table('admins')->where('username', '=', $uname)->where('password', '=', $pass)->count();
        if ($usercount == 1) {
            $userdata = DB::table('admins')->where('username', '=', $uname)->where('password', '=', $pass)->first();
                $key =   $request->session()->regenerate();
                session([
                    'key' => $key,
                    "uid" => $userdata->id,
                    "name" => $userdata->name,
                    "username" => $userdata->username
                ]);
                return redirect('/dashboard');
           
        } else {
            return view('/login')->with('errorcode', "Invalid Credentials! Please Check Your Credentials!");
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}

