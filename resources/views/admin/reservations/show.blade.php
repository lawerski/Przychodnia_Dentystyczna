{{-- filepath: resources/views/admin/reservations/show.blade.php --}}
@extends('layouts.admin', ['pageTitle' => 'Szczegóły rezerwacji'])

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h2>Szczegóły rezerwacji</h2>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $reservation->id }}</td>
        </tr>
        <tr>
            <th>Użytkownik</th>
            <td>{{ $reservation->user->username ?? '' }}</td>
        </tr>
        <tr>
            <th>Usługa</th>
            <td>{{ $reservation->service->service_name ?? '' }}</td>
        </tr>
        <tr>
            <th>Data i godzina</th>
            <td>{{ $reservation->date_time }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge
                    @if($reservation->status === 'potwierdzona') bg-success
                    @elseif($reservation->status === 'oczekująca') bg-warning text-dark
                    @elseif($reservation->status === 'anulowana') bg-danger
                    @elseif($reservation->status === 'wykonana') bg-primary
                    @else bg-secondary
                    @endif">
                    {{ $reservation->status }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Data zgłoszenia</th>
            <td>{{ $reservation->submitted_at }}</td>
        </tr>
    </table>
    <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-warning">Edytuj</a>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary ms-2">Powrót</a>
</div>
@endsection
