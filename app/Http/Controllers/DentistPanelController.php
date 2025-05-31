<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DentistPanelController extends Controller
{
    // In case the names change in the future only this needs to be updated
    private $completed = 'wykonana';
    private $cancelled = 'anulowana';
    private $rejected = 'odrzucona';
    private $pending = 'oczekująca';
    private $confirmed = 'potwierdzona';
    public function show()
    {
        // TODO: Get the dentist ID and authenticate the user
        $dentist = Dentist::first();
        if (!$dentist) {
            // Handle the case when no dentist is found
            return redirect()->back()->withErrors(['Dentist not found.']);
        }
        $offeredServicesIds = $dentist->services->pluck('id');
        $completedProceduresCount = Reservation::whereIn('service_id', $offeredServicesIds)
            ->whereIn('status', [$this->completed, $this->cancelled, $this->rejected])
            ->count();
        $upcomingProceduresCount = Reservation::whereIn('service_id', $offeredServicesIds)
            ->whereIn('status', [$this->pending, $this->confirmed])
            ->count();
        return view('dentist.show', [
            'dentist' => $dentist,
            'completed_procedures_count' => $completedProceduresCount,
            'upcoming_procedures_count' => $upcomingProceduresCount,
        ]);
    }
    /**
     * Display the history of procedures for a specific dentist.
     */
    public function history()
    {
        // TODO: Get the dentist ID and authenticate the user
        $dentist = Dentist::first();
        if (!$dentist) {
            // Handle the case when no dentist is found
            return redirect()->back()->withErrors(['Dentist not found.']);
        }
        $offeredServicesIds = $dentist->services->pluck('id');
        $procedures = Reservation::whereIn('service_id', $offeredServicesIds)
            ->whereIn('status', [$this->cancelled, $this->completed, $this->rejected])
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($reservation) {
            return [
                'patient_name' => $reservation->user->username ?? '',
                'service_name' => $reservation->service->service_name ?? '',
                'date' => $reservation->created_at->format('Y-m-d H:i'),
                'status' => $reservation->status,
            ];
            });

        return view('dentist.history', [
            'procedures' => $procedures,
        ]);
    }

    /**
     * Display the upcoming procedures for a specific dentist.
     */
    public function upcoming()
    {
        // TODO: Get the dentist ID and authenticate the user
        $dentist = Dentist::first();
        if (!$dentist) {
            // Handle the case when no dentist is found
            return redirect()->back()->withErrors(['Dentist not found.']);
        }
        $offeredServicesIds = $dentist->services->pluck('id');
        $procedures = Reservation::whereIn('service_id', $offeredServicesIds)
            ->whereIn('status', [$this->pending, $this->confirmed])
            ->with(['user', 'service'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($reservation) {
            return [
                'patient_name' => $reservation->user->username ?? '',
                'service_name' => $reservation->service->service_name ?? '',
                'date' => $reservation->created_at->format('Y-m-d H:i'),
                'status' => $reservation->status,
                'reservation' => $reservation,
            ];
            });

        return view('dentist.upcoming', [
            'procedures' => $procedures,
        ]);
    }
}
