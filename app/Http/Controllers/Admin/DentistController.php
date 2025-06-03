<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use App\Models\User;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    public function index()
    {
        $dentists = Dentist::with('user')->get();
        return view('admin.dentists.index', compact('dentists'));
    }

    public function create()
    {
        return view('admin.dentists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:4',
            'phone' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:dentists',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'type' => 'dentist'
        ]);

        Dentist::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'specialization' => $validated['specialization'],
            'license_number' => $validated['license_number'],
        ]);

        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentysta dodany pomyślnie');
    }

    public function edit(Dentist $dentist)
    {
        return view('admin.dentists.edit', compact('dentist'));
    }

    public function update(Request $request, Dentist $dentist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:dentists,license_number,' . $dentist->id,
        ]);

        $dentist->update($validated);

        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dane dentysty zaktualizowane');
    }

    public function destroy(Dentist $dentist)
    {
        $dentist->delete();
        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentysta usunięty');
    }
}