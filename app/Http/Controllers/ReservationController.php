<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private $pending = 'oczekująca';
    private $confirmed = 'potwierdzona';
    private $completed = 'wykonana';
    private $cancelled = 'anulowana';


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
