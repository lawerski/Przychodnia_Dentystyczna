@extends('layouts.dentist', ['pageTitle' => 'Zabiegi dentystyczne'])

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Zabiegi dentystyczne</h1>
        <p>W tej sekcji możesz przeglądać i zarządzać zabiegami dentystycznymi.</p>

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
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procedures as $procedure)
                                <tr>
                                    <td>{{ $procedure->name }}</td>
                                    <td>{{ $procedure->description }}</td>
                                    <td>{{ $procedure->duration }} minut</td>
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
@endsection
