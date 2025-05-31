<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private $rejected = 'odrzucona';
    private $pending = 'oczekująca';
    private $confirmed = 'potwierdzona';
    /**
     * Accept reservation by the dentist
     */
    public function accept(Reservation $reservation)
    {
        // TODO: Auth user should be a dentist with this reservation
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
    /**
     * Decline reservation by the dentist
     */
    public function decline(Reservation $reservation)
    {
        // TODO: Auth user should be a dentist with this reservation
        if ($reservation->status == $this->rejected) {
            return back()->with('error', 'Reservation already rejected.');
        }
        if ($reservation->status !== $this->pending) {
            return back()->with('error', 'Reservation cannot be rejected.');
        }
        $reservation->status = $this->rejected;
        $reservation->save();

        return back()->with('rejected', 'Rezerwacja odrzucona.');
    }
}
