<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// TODO: Add dentist controller
Route::get('/dentist/history', function () {
    $procedures = [
        [
            'service' => 'Konsultacja stomatologiczna',
            'patient_name' => 'Jan Kowalski',
            'date' => '2023-10-01',
            'status' => 'Zakończone',
        ],
        [
            'service' => 'Konsultacja stomatologiczna',
            'patient_name' => 'Jan Kowalski',
            'date' => '2023-10-01',
            'status' => 'Zakończone',
        ]
    ];
    return view('dentist.history', [
        'procedures' => $procedures,
    ]);
});
