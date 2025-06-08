
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edytuj dentystę</h2>

    <form method="POST" action="{{ route('admin.dentists.update', $dentist) }}" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Imię</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $dentist->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nazwisko</label>
            <input type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" 
                   value="{{ old('surname', $dentist->surname) }}" required>
            @error('surname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Specjalizacja</label>
            <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" 
                   value="{{ old('specialization', $dentist->specialization) }}" required>
            @error('specialization')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Numer licencji</label>
            <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" 
                   value="{{ old('license_number', $dentist->license_number) }}" required>
            @error('license_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Zdjęcie</label>
            @if($dentist->image_path)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $dentist->image_path) }}" 
                         alt="Zdjęcie dentysty" 
                         style="max-width: 200px; height: auto;">
                </div>
            @endif
            <input type="file" 
                   name="image" 
                   class="form-control @error('image') is-invalid @enderror" 
                   accept="image/jpeg,image/png,image/jpg,image/gif">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Zapisz zmiany</button>
        <a href="{{ route('admin.dentists.index') }}" class="btn btn-secondary">Anuluj</a>
    </form>
</div>
@endsection