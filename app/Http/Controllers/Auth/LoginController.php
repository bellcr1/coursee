<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Override the authenticated method from AuthenticatesUsers trait
    protected function authenticated(Request $request, $user)
    {
        session([
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role
        ]);

        return redirect()->intended($this->redirectPath());
    }

    // Override the logout method
    public function logout(Request $request)
    {
        session()->flush(); // Clear all session data
        $this->guard()->logout();
        
        return redirect('/');
    }
}
