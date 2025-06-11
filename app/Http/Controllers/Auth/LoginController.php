<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($user->role === 'Admin') {
            return redirect()->intended('/stats');
        }
    
        return redirect()->intended('/');
    
    }

    // Override the logout method
    public function logout(Request $request)
    {
        session()->flush(); // Clear all session data
        $this->guard()->logout();
        
        return redirect('/');
    }
}
