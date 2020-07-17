<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function login()
    {
        return view('admin.login');
    }

    function postLogin(Request $req)
    {
        $credentials= $req->only('email','password');
        $token = Auth::guard()->attempt($credentials);
//        $getU = User::where(['email' => $email])->value('password');
//        if(Hash::check($psw, $getU))
//        {
        if(!empty($token)){
            return view('admin.index',['token'=>$token]);
        }else{

            return redirect()->back();
        }

    }

}
