<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $req)
    {
        $credentials = $req->validated();

        if (! Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }

        $req->session()->regenerate();

        return redirect()->intended(route('movies.index'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $req)
    {
        $user = User::create($req->validated()); //بعد انشاء الحساب بيسجله دخول فورا//

        Auth::login($user);

        return redirect()->route('movies.index');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();//بيلغي كل بيانات السيشن الحاليه//
        $req->session()->regenerateToken();//بيغير توكن csrf عشان اي فورم قديم مفتوح في تاب تانيه ميقدرشي يتبعت بعد الخروج//

        return redirect()->route('login');
    }
}
