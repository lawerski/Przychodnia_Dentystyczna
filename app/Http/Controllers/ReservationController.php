<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private $pending = 'oczekująca';
    private $confirmed = 'potwierdzona';
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

    public function cancel(Reservation $reservation)
    {

        if (!in_array($reservation->status, [$this->pending, $this->confirmed])) {
            return back()->with('error', 'Tylko oczekujące lub potwierdzone rezerwacje mogą być anulowane.');
        }
        
        $reservation->status = 'anulowana';
        $reservation->save();

        return back()->with('success', 'Rezerwacja została anulowana pomyślnie.');
    }

  
    public function complete(Reservation $reservation)
    {
        if ($reservation->status !== $this->confirmed) {
            return back()->with('error', 'Tylko potwierdzone rezerwacje mogą być oznaczone jako wykonane.');
        }
        
        $reservation->status = 'wykonana';
        $reservation->save();
        
        return back()->with('success', 'Zabieg został oznaczony jako wykonany.');
    }
}
