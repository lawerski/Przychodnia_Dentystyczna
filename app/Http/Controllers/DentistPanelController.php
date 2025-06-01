<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;

class DentistPanelController extends Controller
{
    // In case the names change in the future only this needs to be updated
    private $completed = 'wykonana';
    private $cancelled = 'anulowana';
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

        return view('dentist.upcoming', [
            'procedures' => $procedures,
        ]);
    }
    /**
     * Get anonimized reviews for dentist.
     */
    public function reviews()
    {
        // TODO: Get the dentist ID and authenticate the user
        $dentist = Dentist::first();
        if (!$dentist) {
            // Handle the case when no dentist is found
            return redirect()->back()->withErrors(['Dentist not found.']);
        }
        $reviews = Review::where('dentist_id', $dentist->id);

        return view('dentist.review', [
            'reviews' => $reviews->get()->map(function ($review) {
                return [
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => \Carbon\Carbon::parse($review->created_at)->format('Y-m-d'),
                ];
            }),
        ]);
    }
    /**
     * Offered procedures.
     */
    public function services()
    {
        // TODO: Get the dentist ID and authenticate the user
        $dentist = Dentist::first();
        if (!$dentist) {
            // Handle the case when no dentist is found
            return redirect()->back()->withErrors(['Dentist not found.']);
        }
        $services = $dentist->services;

        return view('dentist.services', [
            'services' => $services,
        ]);
    }

}
