<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OTPHP\TOTP;
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

            // Jeśli użytkownik ma aktywne TOTP, pokaż formularz TOTP
        if ($user->totp_secret) {
            // Wyloguj i zapisz ID do sesji
            session(['2fa:user:id' => $user->id]);
            Auth::logout();
            return view('auth.totp_verify');
        }

            // Jeśli nie ma TOTP, normalne przekierowanie
            return $this->redirectByRole($user);
        }

        return back()->withErrors([
            'email' => 'Podane dane są nieprawidłowe.',
        ])->onlyInput('email');
    }
    protected function redirectByRole($user)
    {
        if ($user->type === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->type === 'dentist') {
            return redirect()->route('dentist.dashboard');
        } elseif ($user->type === 'patient') {
            return redirect()->route('patient.dashboard');
        }
        return redirect('/');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }


    public function verifyTotp(Request $request)
    {
        $request->validate([
            'totp_code' => ['required', 'digits:6'],
        ]);

        $userId = session('2fa:user:id');
        $user = \App\Models\User::find($userId);

        if (!$user || !$user->totp_secret) {
            return redirect()->route('login')->withErrors(['email' => 'Sesja wygasła. Zaloguj się ponownie.']);
        }

        $totp = TOTP::create($user->totp_secret);

        if ($totp->verify($request->input('totp_code'))) {
            Auth::login($user);
            session()->forget('2fa:user:id');
            // Przekierowanie zależne od roli
            return $this->redirectByRole($user);
        } else {
            return back()->withErrors(['totp_code' => 'Nieprawidłowy kod TOTP']);
        }

    }
}
