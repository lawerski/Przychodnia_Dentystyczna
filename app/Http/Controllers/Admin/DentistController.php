<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    public function index()
    {
        $dentists = Dentist::all();
        return view('admin.dentists.index', compact('dentists'));
    }

    public function create()
    {
        return view('admin.dentists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'experience' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('dentists', 'public');
        }

        Dentist::create($validated);

        return redirect()->route('dentists.index')->with('success', 'Dentysta dodany.');
    }

    public function show(string $id)
    {
        $dentist = Dentist::findOrFail($id);
        return view('admin.dentists.show', compact('dentist'));
    }

    public function edit(string $id)
    {
        $dentist = Dentist::findOrFail($id);
        return view('admin.dentists.edit', compact('dentist'));
    }

    public function update(Request $request, string $id)
    {
        $dentist = Dentist::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'experience' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('dentists', 'public');
        }

        $dentist->update($validated);

        return redirect()->route('dentists.index')->with('success', 'Dentysta zaktualizowany.');
    }

    public function destroy(string $id)
    {
        $dentist = Dentist::findOrFail($id);
        $dentist->delete();

        return redirect()->route('dentists.index')->with('success', 'Dentysta usunięty.');
    }
}