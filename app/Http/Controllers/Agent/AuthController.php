<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('agent.auth.login');
    }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'exists:users,email'],
            'password' => ['sometimes', 'required']
        ]);

        auth('person')->logout();

        $email = $request->get('email');
        $user  = User::where('email', $email)->first();

        if(!isset($user)) {
            // return redirect()->back()->with('error', 'Invalid email or password.');
            throw ValidationException::withMessages(['email' => 'Invalid email or password.']);
        }

        if($request->has('password')) {
            if(Auth::guard('agent')->attempt($request->only('email', 'password'))) {
                return redirect()->route('agent.dashboard')->with('success', 'Welcome back.');
            }

            Auth::guard('agent')->loginUsingId($user->id);
            throw ValidationException::withMessages(['email' => 'Invalid email or password.']);
        }
    }

    public function logout()
    {
        auth()->guard('agent')->logout();
        Session::flush();
        return redirect()->route('agent.login')->with('success','Successfully logged out');
    }
}
