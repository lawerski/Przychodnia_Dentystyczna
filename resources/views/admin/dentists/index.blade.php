
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Lista dentystów</h2>
        <a href="{{ route('admin.dentists.create') }}" class="btn btn-primary">Dodaj dentystę</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Specjalizacja</th>
                    <th>Nr licencji</th>
                    <th>Nazwa użytkownika</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dentists as $dentist)
                <tr>
                    <td>{{ $dentist->id }}</td>
                    <td>{{ $dentist->name }}</td>
                    <td>{{ $dentist->surname }}</td>
                    <td>{{ $dentist->specialization }}</td>
                    <td>{{ $dentist->license_number }}</td>
                    <td>{{ $dentist->user->username }}</td>
                    <td>
                        <a href="{{ route('admin.dentists.edit', $dentist) }}" class="btn btn-sm btn-warning">Edytuj</a>
                        <form action="{{ route('admin.dentists.destroy', $dentist) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Czy na pewno chcesz usunąć tego dentystę?')">Usuń</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection