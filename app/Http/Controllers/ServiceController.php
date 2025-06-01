<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Models\Dentist;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $isAdmin = auth()->user()->type === 'admin';

        if ($isAdmin){
            $dentists = Dentist::all();
            return view('service.admin.edit', [
                'service' => $service,
                'dentists' => $dentists,
            ]);
        } else {
            $dentist = $service->dentist;
            $dentistName = $dentist->name ?? '';
            $dentistSurname = $dentist->surname ?? '';
            $dentistSpecialization = $dentist->specialization ?? '';
            $dentistText = $dentistName . ' ' . $dentistSurname . ' - ' . $dentistSpecialization;
            return view('service.dentist.edit', [
                'service' => $service,
                'dentist_name' => $dentistText,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // TODO: Validate if service is edited by admin or dentist who owns it
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
