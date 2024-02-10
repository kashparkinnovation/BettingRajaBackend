<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getBanner(Request $request)
    {
        $data = Banner::all();
        return view('banner', compact('data'));
    }

    public function insert_Banner(Request $request)
    {
        $newBanner = new Banner;
        if (isset($request->image)) {
            $imageName = time() . rand(10000, 1000000) . '.' . $request->image->extension();
            $request->image->move(public_path('images/banners/'), $imageName);
            $imageimagePath = "images/banners/" . $imageName;
            $newBanner->image = $imageimagePath;
        } else {
            $newBanner->image = "na";
        }
        $newBanner->save();
        return redirect('/getBanner');
    }
    public function delete_Banner(Request $request){
        $id= $request->get('id');
        Banner::destroy($id);
        return redirect('/getBanner');
    }
}
