<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('auth.login');
        }

        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'name' => ['required'],
                'password' => ['required'],
            ]);

            if (auth()->attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()
                    ->intended(route('home'))
                    ->with('success', 'You are now logged in.');
            }

            return back()->withErrors([
                'name' => 'The provided credentials do not match our records.',
            ])->onlyInput('name');
        }

        abort(400, 'Only GET and POST requests are allowed.');
    }
}
