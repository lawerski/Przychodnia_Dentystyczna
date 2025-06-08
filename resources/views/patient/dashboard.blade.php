@extends('layouts.patient', ['pageTitle' => 'Panel Pacjent'])

@section('content')
<div class="container mt-4">
    <h2>Panel Pacjent</h2>
    <p>Pusty panel Pacjent</p>
    <a href="{{ route('patient.profile.edit') }}" class="btn btn-secondary mt-3">Edytuj profil</a>
</div>
@endsection
