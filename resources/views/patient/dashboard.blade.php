@extends('layouts.patient', ['pageTitle' => 'Panel Pacjent'])

@section('content')
<div class="container mt-4">
    <h2>Panel Pacjent</h2>
    <a href="{{ route('patient.profile.edit') }}" class="btn btn-secondary mt-3 mb-4">Edytuj profil</a>

    <h3 class="mt-4">Historia zabiegów</h3>
    @if($reservations->isEmpty())
        <div class="alert alert-info">Brak zrealizowanych zabiegów.</div>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nazwa zabiegu</th>
                <th>Dentysta</th>
                <th>Data</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->service->service_name ?? '-' }}</td>
                <td>{{ $reservation->service->dentist->name ?? '' }} {{ $reservation->service->dentist->surname ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($reservation->date_time)->format('Y-m-d H:i') }}</td>
                <td>
                    <span class="badge 
                        @if($reservation->status === 'wykonana') bg-success
                        @elseif($reservation->status === 'potwierdzona') bg-primary
                        @elseif($reservation->status === 'anulowana') bg-danger
                        @else bg-secondary
                        @endif">
                        {{ $reservation->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <h3 class="mt-5">Kalendarz nadchodzących zabiegów</h3>
    @if($upcoming->isEmpty())
        <div class="alert alert-info">Brak nadchodzących zabiegów.</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Data</th>
                <th>Zabieg</th>
                <th>Dentysta</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($upcoming as $reservation)
            <tr>
                <td>{{ \Carbon\Carbon::parse($reservation->date_time)->format('Y-m-d H:i') }}</td>
                <td>{{ $reservation->service->service_name ?? '-' }}</td>
                <td>{{ $reservation->service->dentist->name ?? '' }} {{ $reservation->service->dentist->surname ?? '' }}</td>
                <td>
                    <span class="badge 
                        @if($reservation->status === 'potwierdzona') bg-primary
                        @elseif($reservation->status === 'oczekująca') bg-warning text-dark
                        @else bg-secondary
                        @endif">
                        {{ $reservation->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
