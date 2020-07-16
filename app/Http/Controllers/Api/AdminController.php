<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function login()
    {
        return view('admin.login');
    }

    function postLogin(Request $req)
    {
        $email = $req->email;
        $psw = $req->psw;
        $getU = User::where(['email' => $email])->value('password');
        if(Hash::check($psw, $getU))
        {
            return redirect('/adminapi');
        } else {
            return redirect()->back();
        }
    }
}
