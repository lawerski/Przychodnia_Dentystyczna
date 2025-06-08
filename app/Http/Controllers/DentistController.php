<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dentist $dentist)
    {
        if (!$dentist) {
            return redirect()->back()->withErrors(['Dentist not found.']);
        }
        return view('dentists.show', [
            'dentist' => $dentist,
            'reviews_count' => $dentist->reviews()->count(),
            'reviews' => $dentist->reviews()->orderBy('updated_at', 'desc')->paginate(6),
            'average_rating' => $dentist->reviews()->avg('rating'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dentist $dentist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dentist $dentist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dentist $dentist)
    {
        //
    }
}
