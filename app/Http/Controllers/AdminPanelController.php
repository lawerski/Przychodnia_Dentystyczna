<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{
    public function index()
    {
        if (Auth::user()->type !== 'admin') {
            abort(403, 'Brak dostępu');
        }
        return view('admin.dashboard');
    }
}
