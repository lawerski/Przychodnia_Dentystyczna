<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DentistPanelController extends Controller
{
    public function index()
    {
        if (Auth::user()->type !== 'dentist') {
            abort(403, 'Brak dostępu');
        }
        return view('dentist.dashboard');
    }
}
