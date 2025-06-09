@extends('layouts.app')
@if (session('accepted'))
    <div class="alert alert-success container mt-4" id="accepted-alert">
        {{ session('accepted') }}
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('accepted-alert').remove();"></button>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success container mt-4" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('success-alert').remove();"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger container mt-4" id="error-alert">
        {{ session('error') }}
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('error-alert').remove();"></button>
    </div>
@endif


@if (count($procedures) === 0)
    <div class="alert alert-info" role="alert">
        Brak zapisanych zabiegów.
    </div>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Zabieg</th>
                <th>Pacjent</th>
                <th>Data</th>
                <th>Status</th>
                @if (request()->routeIs('dentist.upcoming'))
                    <th>Akcja</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($procedures as $procedure)
                <tr>
                    <td>{{ $procedure['service_name'] }}</td>
                    <td>{{ $procedure['patient_name'] }}</td>
                    <td>{{ $procedure['date'] }}</td>
                    <td>
                        <span class="badge
                            @if ($procedure['status'] === 'anulowana' || $procedure['status'] === 'odrzucona') bg-danger
                            @elseif ($procedure['status'] === 'wykonana') bg-info
                            @elseif ($procedure['status'] === 'oczekująca') bg-warning text-dark
                            @elseif ($procedure['status'] === 'potwierdzona') bg-success
                            @endif">
                            {{ $procedure['status'] }}
                        </span>
                    </td>
                    @if (request()->routeIs('dentist.upcoming'))
                        <td class="p-1 align-middle">
                            @if ($procedure['status'] === 'oczekująca')
                                <form action="{{ route('reservation.accept', ['reservation' => $procedure['reservation']]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary btn-sm px-2 py-1">Potwierdź</button>
                                </form>
                            @endif
                            
                            @if ($procedure['status'] === 'potwierdzona')
                                <form action="{{ route('reservation.complete', ['reservation' => $procedure['reservation']]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm px-2 py-1">Wykonano</button>
                                </form>
                            @endif
                            
                            @if (in_array($procedure['status'], ['oczekująca', 'potwierdzona']))
                                <form action="{{ route('reservation.cancel', ['reservation' => $procedure['reservation']]) }}" method="POST" style="display:inline; margin-left: 5px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm px-2 py-1" 
                                            onclick="return confirm('Czy na pewno chcesz anulować tę rezerwację?')">
                                        Anuluj
                                    </button>
                                </form>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
