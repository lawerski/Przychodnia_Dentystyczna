
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edytuj dentystę</h2>

    <form method="POST" action="{{ route('admin.dentists.update', $dentist) }}" class="mt-4">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Imię</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $dentist->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nazwisko</label>
            <input type="text" name="surname" class="form-control" value="{{ old('surname', $dentist->surname) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Specjalizacja</label>
            <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $dentist->specialization) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Numer licencji</label>
            <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $dentist->license_number) }}" required>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit" class="btn btn-success">Zapisz zmiany</button>
        <a href="{{ route('admin.dentists.index') }}" class="btn btn-secondary">Anuluj</a>
    </form>
</div>
@endsection