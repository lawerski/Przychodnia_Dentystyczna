<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();
        if ($user->type === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->type === 'dentist') {
            return redirect()->route('dentist.dashboard');
        } elseif ($user->type === 'patient') {
            return redirect()->route('patient.dashboard');
        }
        return redirect('/'); // fallback
    }

        return back()->withErrors([
            'email' => 'Podane dane są nieprawidłowe.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
