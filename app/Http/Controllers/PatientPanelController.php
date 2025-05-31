<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientPanelController extends Controller
{
    public function index()
    {
        return view('patient.dashboard');
    }
}
