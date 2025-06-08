<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use OTPHP\TOTP;

class DentistPanelController extends Controller
{
    // In case the names change in the future only this needs to be updated
    private $completed = 'wykonana';
    private $cancelled = 'anulowana';
    private $pending = 'oczekująca';
    private $confirmed = 'potwierdzona';

    private function getDentist()
    {
        $user = Auth::user();
        if (!$user || !$user->dentist) {
            return null;
        }
        return $user->dentist;
    }

    public function show()
    {
        try {
            $dentist = $this->getDentist();

            $offeredServicesIds = $dentist->services->pluck('id');
            $completedProceduresCount = Reservation::whereIn('service_id', $offeredServicesIds)
                ->whereIn('status', [$this->completed, $this->cancelled])
                ->count();
            $upcomingProceduresCount = Reservation::whereIn('service_id', $offeredServicesIds)
                ->whereIn('status', [$this->pending, $this->confirmed])
                ->count();

            $reviews = Review::where('dentist_id', $dentist->id)
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get()
                ->map(function ($review) {
                    return [
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => \Carbon\Carbon::parse($review->created_at)->format('Y-m-d'),
                    ];
                });

            return view('dentist.show', [
                'dentist' => $dentist,
                'completed_procedures_count' => $completedProceduresCount,
                'upcoming_procedures_count' => $upcomingProceduresCount,
                'reviews' => $reviews,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Nie masz uprawnień do tej strony.']);
        }
    }

    /**
     * Display the history of procedures for a specific dentist.
     */
    public function history()
    {
        try {
            $dentist = $this->getDentist();

            $offeredServicesIds = $dentist->services->pluck('id');
            $procedures = Reservation::whereIn('service_id', $offeredServicesIds)
                ->whereIn('status', [$this->cancelled, $this->completed])
                ->with(['user', 'service'])
                ->orderBy('date_time', 'asc')
                ->get()
                ->map(function ($reservation) {
                    return [
                        'patient_name' => $reservation->user->username ?? '',
                        'service_name' => $reservation->service->service_name ?? '',
                        'date' => \Carbon\Carbon::parse($reservation->date_time)->format('Y-m-d H:i'),
                        'status' => $reservation->status,
                    ];
                });

            return view('dentist.history', [
                'procedures' => $procedures,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Nie masz uprawnień do tej strony.']);
        }
    }

    /**
     * Display the upcoming procedures for a specific dentist.
     */
    public function upcoming()
    {
        try {
            $dentist = $this->getDentist();

            $offeredServicesIds = $dentist->services->pluck('id');
            $procedures = Reservation::whereIn('service_id', $offeredServicesIds)
                ->whereIn('status', [$this->pending, $this->confirmed])
                ->with(['user', 'service'])
                ->orderBy('date_time', 'asc')
                ->get()
                ->map(function ($reservation) {
                    return [
                        'patient_name' => $reservation->user->username ?? '',
                        'service_name' => $reservation->service->service_name ?? '',
                        'date' => \Carbon\Carbon::parse($reservation->date_time)->format('Y-m-d H:i'),
                        'status' => $reservation->status,
                        'reservation' => $reservation,
                    ];
                });
            return view('dentist.upcoming', ['procedures' => $procedures]);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Nie masz uprawnień do tej strony.']);
        }
    }

    public function editProfile()
    {
        $user = Auth::user();
        $dentist = $this->getDentist();
        return view('dentist.profile', compact('user', 'dentist'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $dentist = $this->getDentist();

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $user->id,
                'regex:/^[a-zA-Z0-9]+$/'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ],
            'phone' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^\+?[0-9]{9,15}$/'
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s-]+$/'
            ],
            'surname' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s-]+$/'
            ],
            'specialization' => [
                'required',
                'string',
                'max:255'
            ],
            'license_number' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Z0-9]+$/',
                'unique:dentists,license_number,' . $dentist->id
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ]
        ], [
            'username.required' => 'Nazwa użytkownika jest wymagana.',
            'username.regex' => 'Nazwa użytkownika może zawierać tylko litery i cyfry.',
            'username.unique' => 'Ta nazwa użytkownika jest już zajęta.',
            'email.required' => 'Adres email jest wymagany.',
            'email.email' => 'Podaj prawidłowy adres email.',
            'email.unique' => 'Ten adres email jest już zajęty.',
            'phone.regex' => 'Podaj prawidłowy numer telefonu.',
            'password.min' => 'Hasło musi mieć co najmniej 8 znaków.',
            'password.regex' => 'Hasło musi zawierać co najmniej jedną literę i jedną cyfrę.',
            'password.confirmed' => 'Hasła nie są zgodne.',
            'name.required' => 'Imię jest wymagane.',
            'name.regex' => 'Imię może zawierać tylko litery, spacje i myślniki.',
            'surname.required' => 'Nazwisko jest wymagane.',
            'surname.regex' => 'Nazwisko może zawierać tylko litery, spacje i myślniki.',
            'specialization.required' => 'Specjalizacja jest wymagana.',
            'license_number.required' => 'Numer licencji jest wymagany.',
            'license_number.regex' => 'Numer licencji może zawierać tylko wielkie litery i cyfry.',
            'license_number.unique' => 'Ten numer licencji jest już zajęty.',
            'image.image' => 'Plik musi być obrazem.',
            'image.mimes' => 'Dozwolone formaty obrazów: jpeg, png, jpg, gif.',
            'image.max' => 'Maksymalny rozmiar obrazu to 2MB.',
            'image.dimensions' => 'Wymiary obrazu muszą być między 100x100 a 2000x2000 pikseli.'
        ]);

        DB::beginTransaction();

        try {
            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => $validated['password'] ?? $user->password
            ]);

            $dentistData = [
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'specialization' => $validated['specialization'],
                'license_number' => $validated['license_number']
            ];

            if ($request->hasFile('image')) {
                if ($dentist->image_path) {
                    Storage::disk('public')->delete($dentist->image_path);
                }
                $dentistData['image_path'] = $request->file('image')->store('dentists', 'public');
            }

            $dentist->update($dentistData);

            DB::commit();
            return redirect()->route('dentist.dashboard')->with('success', 'Dane zostały zaktualizowane pomyślnie.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Wystąpił błąd podczas aktualizacji danych.']);
        }
    }

    public function reviews()
    {
        try {
            $dentist = $this->getDentist();

            $reviews = Review::where('dentist_id', $dentist->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($review) {
                    return [
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => \Carbon\Carbon::parse($review->created_at)->format('Y-m-d'),
                    ];
                });

            return view('dentist.review', [
                'reviews' => $reviews,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Nie masz uprawnień do tej strony.']);
        }
    }
    
    /**
     * Get data for calendar view.
     */
    public function calendar()
    {
        $dentist = $this->getDentist();
        if (!$dentist) return redirect()->back()->withErrors(['Dentist not found.']);

        $offeredServicesIds = $dentist->services->pluck('id');
        $procedures = Reservation::whereIn('service_id', $offeredServicesIds)
            ->whereIn('status', [$this->pending, $this->confirmed])
            ->with(['user', 'service'])
            ->orderBy('date_time', 'asc')
            ->get()
            ->map(function ($reservation) {
            return [
                'date' => \Carbon\Carbon::parse($reservation->date_time)->format('Y-m-d H:i'),
            ];
            });

        return view('dentist.calendar', [
            'procedures' => $procedures,
        ]);
    }

    /**
     * Offered procedures.
     */
    public function services()
    {
        $dentist = $this->getDentist();
        if (!$dentist) return redirect()->back()->withErrors(['Dentist not found.']);

        $services = $dentist->services;

        return view('dentist.services', [
            'services' => $services,
        ]);
    }

    public function generateTotpSecret()
    {
        $user = Auth::user();

        if (!$user->totp_secret) {
            $totp = TOTP::create();
            $user->totp_secret = $totp->getSecret();
            $user->save();
        }
        $totp = TOTP::create($user->totp_secret);

        $label = $user->email ?: $user->username;
        if (!$label) {
            $label = 'user-' . $user->id;
        }
        $totp->setLabel($label);
        $totp->setIssuer(config('app.name', 'Przychodnia Dentystyczna'));

        $provisioningUri = $totp->getProvisioningUri();
        $qrTemplate = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=%s';
        $qrCodeUri = sprintf($qrTemplate, urlencode($provisioningUri));

        return view('auth.totp', [
            'qrCodeUri' => $qrCodeUri,
            'secret' => $user->totp_secret,
        ]);
    }
}
