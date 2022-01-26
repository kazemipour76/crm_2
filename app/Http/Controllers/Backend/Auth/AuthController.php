<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Utilities\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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

        if (Auth::attempt($data)) {
            request()->session()->regenerate();
            return redirect(\App\Utilities\Url::admin('/dash'));
        }
        return redirect()->back();
//        return redirect('dash');
        // todo get data from user and validate [email , password]
        // todo Auth::attempt
        // redirect to dashboard

    }

    public function registerPage()
    {
        return view('backend.auth.auth.register');
    }

    public function register()
    {
        $data = request()->validate([
            'email' => 'required',
            'password' => 'required',
            'repassword' => 'required:same:password'
        ]);


        $userCount = User::where('email', request()->get('email'))->count();
        if ($userCount > 0) {
            MessageBag::push("شما قبلا ثبت نام کرده اید");
            return redirect()->back();
        }

        $user = new User();
        $user->name = request()->get('email');
        $user->email = request()->get('email');
        $user->password = Hash::make(request()->get('password'));
        if ($user->save()) {
            $loginData = [
                'email' => request()->get('email'),
                'password' => request()->get('password')
            ];
            if (Auth::attempt($loginData)) {
                request()->session()->regenerate();
                return redirect(\App\Utilities\Url::admin('/dash'));
            }
        }

        return redirect()->back();


    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
