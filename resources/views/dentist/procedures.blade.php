@extends('layouts.dentist', ['pageTitle' => 'Zabiegi dentystyczne'])

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Zabiegi dentystyczne</h1>
        <p>W tej sekcji możesz przeglądać i zarządzać zabiegami dentystycznymi.</p>

        @if (session('accepted'))
            <div class="alert alert-success container mt-4" id="success-alert">
                {{ session('accepted') }}
                <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('success-alert').remove();"></button>
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

        <div class="row">
            <div class="col-md-12">
                <h2>Lista zabiegów</h2>
                @if($procedures->isEmpty())
                    <p>Brak zabiegów do wyświetlenia.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nazwa zabiegu</th>
                                <th>Opis</th>
                                <th>Czas trwania</th>
                                @if (request()->routeIs('dentist.upcoming'))
                                    <th>Akcja</th>
                                @endif
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procedures as $procedure)
                                <tr>
                                    <td>{{ $procedure->name }}</td>
                                    <td>{{ $procedure->description }}</td>
                                    <td>{{ $procedure->duration }} minut</td>
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
                                    <td>
                                        <a href="{{ route('dentist.procedure.edit', $procedure->id) }}" class="btn btn-primary btn-sm">Edytuj</a>
                                        <form action="{{ route('dentist.procedure.delete', $procedure->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ route('dentist.procedure.create') }}" class="btn btn-success">Dodaj nowy zabieg</a>
            </div>
        </div>
    </div>
@endsection
