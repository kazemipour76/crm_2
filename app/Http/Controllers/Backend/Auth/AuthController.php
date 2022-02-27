<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Utilities\MessageBag;
use App\Utilities\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;


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
        }else{
            MessageBag::push("ایمیل یا کلمه عبور صحیح نمی باشد");
            return redirect()->back();
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
            'name' => 'required|regex:/(^([a-zA-z0-9]+)(\d+)?$)/u',
            'password' => ['required', 'string', 'confirmed', Password::min(4)],
            'password_confirmation' => ['required'],
        ]);

        $userCount = User::where('email', request()->get('email'))->count();
        if ($userCount > 0) {
            MessageBag::push("شما قبلا ثبت نام کرده اید");
            return redirect()->back();
        }

            $user = new User();
            $user->name = request()->get('name');
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
