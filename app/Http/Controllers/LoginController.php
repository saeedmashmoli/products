<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function checkLogin(Request $request){
        if (Auth::attempt(array('username' => $request->username, 'password' => $request->password))){
            $user = auth()->user();
            if ($user->status == 0){
                Auth::logout();
                return 'Status Failed';
            }
            if ($user->role_id != 2){

                return redirect(route('users.index'));
            }else{
                return redirect(route('/'));
            }
        }
        else {
            return back()->withErrors('نام کاربری یا رمز عبور اشتباه است!');
        }
    }
    public function register(){

    }
    public function login(){
        return view('login');
    }
    public function loginUser(Request $request)
    {
        $user = User::whereUsername($request->username)->first();
        if ($user) {
            if (Auth::attempt(array('username' => $request->username, 'password' => $request->password))) {
                $user = auth()->user();
                if ($user->status == 0) {
                    Auth::logout();
                    return 'Status Failed';
                }
                Auth::login($user);
                return $user;
            } else {
                return 'Wrong User';
            }
        }else{
            $request->merge(['role_id' => 2,'password' => bcrypt($request->input('password'))]);
            $user = User::create($request->all());
            Auth::login($user);
            return $user;
        }

    }
    public function logout(Request $request){
        Auth::guard();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/login');
    }
    public function checkRegister(Request $request){

    }
}
