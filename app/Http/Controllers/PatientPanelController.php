<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PatientPanelController extends Controller
{
    public function index()
    {
        return view('patient.dashboard');
    }
    public function editProfile()
    {
        $user = Auth::user();
        return view('patient.profile', compact('user'));
    }
    public function updateProfile(Request $request)
{
    $user = Auth::user();
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:4|confirmed',
    ]);
    if (!empty($validated['password'])) {
        $validated['password'] = bcrypt($validated['password']);
    } else {
        unset($validated['password']);
    }
    $user->update($validated);

    return back()->with('success', 'Dane zostały zaktualizowane.');
}
}
