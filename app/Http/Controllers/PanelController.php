<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index(){
        return view('panel');
    }
    public function profile(){
        $user = auth()->user();
        return view('profile',compact('user'));
    }
    public function update(Request $request){
        if ($request->password != $request->confirmPassword)
            return back()->withErrors('تایید رمز عبور وارد شده و تایید رمز عبور مطابقت ندارد');
        $user = auth()->user();
        if ($user->username != $request->username)
            $request->validate(['username' => 'required|unique:users',]);
        $request->validate([
            'username' => 'nullable|required',
            'email' => 'nullable|email',
            'mobile' => 'nullable|numeric',
        ]);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->mobile = $request->mobile;

        if (trim($request->password) !== null)
            $user->password = bcrypt(trim($request->password));
        $user->save();
        return redirect(route('panel'));
    }
}
