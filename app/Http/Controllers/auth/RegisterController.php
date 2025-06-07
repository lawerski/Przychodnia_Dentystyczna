<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'password' => 'required|string|min:4|confirmed',
            'type' => 'required|in:patient,dentist',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        // FIXME: If the user is a dentist, create a Dentist record
        if ($request->input('type') === 'dentist') {
            Dentist::create([
            'user_id' => $user->id,
            'name' => $request->input('name', 'temp'),
            'surname' => $request->input('surname', 'temp'),
            'specialization' => $request->input('specialization', 'temp'),
            'license_number' => $request->input('license_number', 'temp'),
            ]);
        }

        Auth::login($user);

        return redirect()->route('main')->with('success', 'Rejestracja zakończona sukcesem!');
    }
}
