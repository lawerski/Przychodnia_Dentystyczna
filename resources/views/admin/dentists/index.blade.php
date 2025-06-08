
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
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Zdjęcie</th>
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
                    <td>
                        @if($dentist->image_path)
                            <img src="{{ asset('storage/' . $dentist->image_path) }}" 
                                 alt="Zdjęcie {{ $dentist->name }}" 
                                 class="rounded-circle"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $dentist->id }}</td>
                    <td>{{ $dentist->name }}</td>
                    <td>{{ $dentist->surname }}</td>
                    <td>{{ $dentist->specialization }}</td>
                    <td>{{ $dentist->license_number }}</td>
                    <td>{{ $dentist->user->username }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.dentists.edit', $dentist) }}" 
                               class="btn btn-sm btn-warning me-2">
                                <i class="bi bi-pencil-fill"></i> Edytuj
                            </a>
                            <form action="{{ route('admin.dentists.destroy', $dentist) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Czy na pewno chcesz usunąć tego dentystę?')">
                                    <i class="bi bi-trash-fill"></i> Usuń
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection