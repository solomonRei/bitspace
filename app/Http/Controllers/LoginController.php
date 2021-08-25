<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return redirect('https://app.bitspace.kz/User/Login');
    }

    public function doAuth(Request $request)
    {
        $login = isset($request->login) ? $request->login : 'developer';
        if ($user = User::withTrashed()->where('login', $login)->first()) {

            Auth::loginUsingId($user->id);
//            Auth::login($user);
            return redirect()->route('profile.index');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
