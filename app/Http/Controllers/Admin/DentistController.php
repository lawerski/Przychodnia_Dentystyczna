<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'phone' => $validated['phone'],
                'type' => 'dentist'
            ]);

            $dentistData = [
                'user_id' => $user->id,
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'specialization' => $validated['specialization'],
                'license_number' => $validated['license_number']
            ];

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('dentists', 'public');
                $dentistData['image_path'] = $path;
            }

            Dentist::create($dentistData);

            DB::commit();
            return redirect()->route('admin.dentists.index')
                ->with('success', 'Dentysta został dodany pomyślnie');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Wystąpił błąd podczas dodawania dentysty']);
        }
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($dentist->image_path) {
                Storage::disk('public')->delete($dentist->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('dentists', 'public');
        }

        $dentist->update($validated);

        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dane dentysty zaktualizowane');
    }

    public function destroy(Dentist $dentist)
    {
        if ($dentist->image_path) {
            Storage::disk('public')->delete($dentist->image_path);
        }
        $dentist->delete();
        return redirect()->route('admin.dentists.index')
            ->with('success', 'Dentysta usunięty');
    }

    /**
     * Dodaj opinię do dentysty (widoczne dla wszystkich zalogowanych, warunek zakomentowany)
     */
    public function addReview(Request $request, Dentist $dentist)
    {
        $user = Auth::user();

        // Warunek do odkomentowania, jeśli chcesz ograniczyć tylko do pacjentów po zabiegu:
        // $hadProcedure = \App\Models\Reservation::where('user_id', $user->id)
        //     ->whereHas('service', function($q) use ($dentist) {
        //         $q->where('dentist_id', $dentist->id);
        //     })
        //     ->where('status', 'wykonana')
        //     ->exists();
        // if (!$hadProcedure) {
        //     return back()->with('error', 'Możesz ocenić dentystę tylko po wykonanym zabiegu.');
        // }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'dentist_id' => $dentist->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Dziękujemy za ocenę!');
    }
}
