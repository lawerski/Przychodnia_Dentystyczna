<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReservationController extends Controller
{

    private $pending = 'oczekująca';
    private $confirmed = 'potwierdzona';
    private $completed = 'wykonana';
    private $cancelled = 'anulowana';

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
        if ($hour < 9 || $hour > 15 || !in_array($minute, [0, 15, 30, 45])) {
            return redirect()->back()->with('error', 'Możesz wybrać tylko godziny między 9:00 a 15:00 oraz minuty 00, 15, 30 lub 45.')->withInput();
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
        $reservation->status = $this->pending;
        $reservation->submitted_at = now();
        $reservation->save();

        return redirect()->route('service.index')->with('success', 'Rezerwacja została złożona i oczekuje na potwierdzenie!');
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
        if ($hour < 9 || $hour > 15 || !in_array($minute, [0, 15, 30, 45])) {
            return redirect()->back()->with('error', 'Możesz wybrać tylko godziny między 9:00 a 15:00 oraz minuty 00, 15, 30 lub 45.')->withInput();
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
            ->whereTime('date_time', $dateTime->format('H:i:s'))
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
            return back()->with('error', 'Rezerwacja jest już potwierdzona.');
        }
        if ($reservation->status !== $this->pending) {
            return back()->with('error', 'Tylko oczekujące rezerwacje mogą być potwierdzone.');
        }
        $reservation->status = $this->confirmed;
        $reservation->save();

        return back()->with('success', 'Rezerwacja została potwierdzona.');
    }


    public function availableSlots(Request $request)
    {
        $serviceId = $request->input('service_id');
        $service = Service::findOrFail($serviceId);

        $startHour = 9;
        $endHour = 15;
        $daysToCheck = 7;
        $slots = [];
        $now = Carbon::now();

        for ($day = 0; $day < $daysToCheck; $day++) {
            $date = Carbon::today()->addDays($day);
            for ($hour = $startHour; $hour <= $endHour; $hour++) {
                for ($minute = 0; $minute <= 45; $minute += 15) {
                    // Nie dodawaj slotów po 15:00
                    if ($hour === $endHour && $minute > 0) {
                        continue;
                    }
                    $dateTime = $date->copy()->setHour($hour)->setMinute($minute)->setSecond(0);

                    // Dla dzisiaj nie pokazuj godzin z przeszłości
                    if ($date->isToday() && $dateTime->lessThan($now)) {
                        continue;
                    }

                    $exists = $service->reservations()
                        ->whereDate('date_time', $dateTime->toDateString())
                        ->whereTime('date_time', $dateTime->format('H:i:s'))
                        ->exists();
                    if (!$exists) {
                        $slots[] = $dateTime->format('Y-m-d\TH:i');
                    }
                }
            }
        }
        return response()->json($slots);
    }

    public function cancel(Reservation $reservation)
    {
        if (!in_array($reservation->status, [$this->pending, $this->confirmed])) {
            return back()->with('error', 'Tylko oczekujące lub potwierdzone rezerwacje mogą być anulowane.');
        }

        $reservation->status = $this->cancelled;
        $reservation->save();

        return back()->with('success', 'Rezerwacja została anulowana.');
    }

    public function complete(Reservation $reservation)
    {
        if ($reservation->status !== $this->confirmed) {
            return back()->with('error', 'Tylko potwierdzone rezerwacje mogą być oznaczone jako wykonane.');
        }

        $reservation->status = $this->completed;
        $reservation->save();

        return back()->with('success', 'Zabieg został oznaczony jako wykonany.');
    }
}
