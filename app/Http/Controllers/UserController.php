<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
class UserController extends Controller
{
    // Wyświetl listę użytkowników
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Formularz tworzenia użytkownika
    public function create()
    {
        return view('admin.users.create');
    }

    // Zapisz nowego użytkownika
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'password' => 'required|string|min:4',
            'type' => 'required|in:admin,dentist,patient',
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Użytkownik dodany.');
    }

    // Formularz edycji użytkownika
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Aktualizuj użytkownika
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:4',
            'type' => 'required|in:admin,dentist,patient',
        ]);
        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Użytkownik zaktualizowany.');
    }

    // Usuń użytkownika
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Użytkownik usunięty.');
    }
}
