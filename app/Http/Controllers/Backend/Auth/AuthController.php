<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function loginPage()
    {
        return view('backend.auth.auth.login');
    }

    public function login()
    {
        $data = request()->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

       if(Auth::attempt($data)){
           request()->session()->regenerate();
           return redirect(\App\Utilities\Url::admin('/dash'));
       }
       return redirect()->back();
//        return redirect('dash');
        // todo get data from user and validate [email , password]
        // todo Auth::attempt
        // redirect to dashboard

    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
