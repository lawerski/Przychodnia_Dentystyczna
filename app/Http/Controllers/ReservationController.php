<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;

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
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date_time' => 'required|date',
            'status' => 'required|string',
        ]);
        $validated['submitted_at'] = now();
        Reservation::create($validated);

        return redirect()->route('admin.reservations.index')->with('success', 'Rezerwacja dodana.');
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
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'date_time' => 'required|date',
            'status' => 'required|string',
        ]);
        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')->with('success', 'Rezerwacja zaktualizowana.');
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
