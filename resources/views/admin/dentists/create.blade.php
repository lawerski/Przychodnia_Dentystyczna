@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Dodaj nowego dentystę</h2>

    <form method="POST" action="{{ route('admin.dentists.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Standard user fields -->
        <div class="mb-3">
            <label for="username" class="form-label">Nazwa użytkownika</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                   id="username" name="username" value="{{ old('username') }}">
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Hasło</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Telefon</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" name="phone" value="{{ old('phone') }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <h4 class="mt-4">Dane zawodowe</h4>
        <div class="mb-3">
            <label for="name" class="form-label">Imię</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Zdjęcie</label>
            <input type="file" 
                   class="form-control @error('image') is-invalid @enderror" 
                   id="image" 
                   name="image"
                   accept="image/jpeg,image/png,image/jpg,image/gif">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="surname" class="form-label">Nazwisko</label>
            <input type="text" class="form-control @error('surname') is-invalid @enderror" 
                   id="surname" name="surname" value="{{ old('surname') }}">
            @error('surname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="specialization" class="form-label">Specjalizacja</label>
            <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                   id="specialization" name="specialization" value="{{ old('specialization') }}">
            @error('specialization')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="license_number" class="form-label">Numer licencji</label>
            <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                   id="license_number" name="license_number" value="{{ old('license_number') }}">
            @error('license_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Zapisz</button>
        <a href="{{ route('admin.dentists.index') }}" class="btn btn-secondary">Anuluj</a>
    </form>
</div>
@endsection