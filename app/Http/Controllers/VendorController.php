<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function vendors()
    {
        $data = DB::table('vendors')->get();
        return view('vendors', compact('data'));
    }
    public function add_new_vendor(Request $request)
    {
        $name = $request->get('name');
        $mobile = $request->get('mobile');
        $username = $request->get('username');
        $password = $request->get('password');
        $nameCode = Str::upper(substr($name, 0, 3));
        $now = Carbon::now();
        $dateTimeCode = $now->format('YmdHis');
        $my_refer_code = "V-".$nameCode . $dateTimeCode;
        $data=['name'=>$name, 'mobile'=>$mobile, 'username'=>$username, 'password'=>$password, 'vendor_code'=>$my_refer_code];
        DB::table('vendors')->insert($data);
        return redirect('/vendors');
    }
}
