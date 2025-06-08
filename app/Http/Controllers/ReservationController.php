<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{

    private $pending = 'oczekująca';
    private $confirmed = 'potwierdzona';

    // Wyświetl listę rezerwacji
    public function index()
    {
        $reservations = Reservation::with(['user', 'service'])->orderByDesc('date_time')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    // Formularz tworzenia rezerwacji
    public function create()
    {
        $users = User::all();
        $services = Service::all();
        return view('admin.reservations.create', compact('users', 'services'));
    }

    // Zapisz nową rezerwację
    public function store(Request $request)
    {

        $user = Auth::user();
        try {
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'date_time' => 'required|date|after:now',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'Nie możesz zarezerowawać terminu w przeszłości lub nie podałeś wszystkich wymaganych danych.')->withInput();
        }

        $dateTime = \Carbon\Carbon::parse($request->date_time);

        // Sprawdź czy godzina mieści się w przedziale 9:00-15:00 (pełne godziny)
        $hour = (int)$dateTime->format('H');
        $minute = (int)$dateTime->format('i');
        if ($hour < 9 || $hour > 15) {

            return redirect()->back()->with('error', 'Możesz wybrać tylko pełną godzinę między 9:00 a 15:00 (np. 09:00, 10:00, ... 15:00).');

        }


        // Pobierz dentystę z usługi
        $service = Service::find($request->service_id);
        if (!$service) {
            return redirect()->back()->with('error', 'Wybrana usługa nie istnieje.');
        }
        $dentistId = $service->dentist_id;

        // Sprawdź czy nie ma już rezerwacji dla tego dentysty o tej godzinie tego dnia
        $exists = \App\Models\Reservation::whereHas('service', function($q) use ($dentistId) {
                $q->where('dentist_id', $dentistId);
            })
            ->whereTime('date_time', $dateTime->format('H:i:s'))
            ->where('status', '!=', 'anulowana')
            ->exists();

        if ($exists) {

            return redirect()->back()->with('error', 'Wybrany dentysta ma już zabieg o tej godzinie. Wybierz inną godzinę.');

        }

        $reservation = new Reservation();
        $reservation->user_id = $user->id;
        $reservation->service_id = $request->service_id;
        $reservation->date_time = $request->date_time;
        $reservation->status = 'oczekująca';
        $reservation->submitted_at = now();
        $reservation->save();

        return redirect()->back()->with('success', 'Rezerwacja została złożona i oczekuje na potwierdzenie.');
    }

    // Pokaż szczegóły rezerwacji
    public function show(Reservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }

    // Formularz edycji rezerwacji
    public function edit(Reservation $reservation)
    {
        $users = User::all();
        $services = Service::all();
        return view('admin.reservations.edit', compact('reservation', 'users', 'services'));
    }

    // Aktualizuj rezerwację
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date_time' => 'required|date|after:now',
            'status' => 'required|string',
        ]);

        $dateTime = \Carbon\Carbon::parse($request->date_time);
        $hour = (int)$dateTime->format('H');
        $minute = (int)$dateTime->format('i');
        if ($hour < 9 || $hour > 15 || $minute != 0) {
            return redirect()->back()->with('error', 'Możesz wybrać tylko pełną godzinę między 9:00 a 15:00 (np. 09:00, 10:00, ... 15:00).');
        }

        $service = Service::find($request->service_id);
        if (!$service) {
            return redirect()->back()->with('error', 'Wybrana usługa nie istnieje.');
        }
        $dentistId = $service->dentist_id;

        // Sprawdź czy nie ma już rezerwacji dla tego dentysty o tej godzinie tego dnia (pomijając aktualną rezerwację)
        $exists = \App\Models\Reservation::whereHas('service', function($q) use ($dentistId) {
                $q->where('dentist_id', $dentistId);
            })
            ->whereDate('date_time', $dateTime->toDateString())
            ->whereTime('date_time', $dateTime->format('H'))
            ->where('id', '!=', $reservation->id)
            ->where('status', '!=', 'anulowana')
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Wybrany dentysta ma już zabieg o tej godzinie. Wybierz inną godzinę.');
        }

        $reservation->update([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'date_time' => $request->date_time,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reservations.edit', $reservation)->with('success', 'Rezerwacja została zaktualizowana.');
    }

    // Usuń rezerwację
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Rezerwacja usunięta.');
    }

    /**
     * Accept reservation by the dentist
     */
    public function accept(Reservation $reservation)
    {
        if ($reservation->status == $this->confirmed) {
            return back()->with('error', 'Reservation already accepted.');
        }
        if ($reservation->status !== $this->pending) {
            return back()->with('error', 'Reservation cannot be accepted.');
        }
        $reservation->status = $this->confirmed;
        $reservation->save();

        return back()->with('accepted', 'Rezerwacja zaakceptowana.');
    }
}
