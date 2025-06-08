@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width:800px;">
    <h2>Moje dane</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('dentist.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <h4>Dane konta</h4>
                <div class="mb-3">
                    <label class="form-label">Nazwa użytkownika*</label>
                    <input type="text" name="username" 
                           class="form-control @error('username') is-invalid @enderror" 
                           value="{{ old('username', $user->username) }}" required
                           pattern="[a-zA-Z0-9]+"
                           title="Nazwa użytkownika może zawierać tylko litery i cyfry">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email*</label>
                    <input type="email" name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefon</label>
                    <input type="text" name="phone" 
                           class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $user->phone) }}"
                           pattern="^\+?[0-9]{9,15}$"
                           placeholder="np. +48123456789">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nowe hasło</label>
                    <input type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"
                           minlength="8">
                    <small class="text-muted">Minimum 8 znaków, co najmniej 1 litera i 1 cyfra</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Potwierdź hasło</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <h4>Dane zawodowe</h4>
                <div class="mb-3">
                    <label class="form-label">Imię*</label>
                    <input type="text" name="name" 
                           class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $dentist->name) }}" 
                           required
                           pattern="[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s-]+"
                           title="Imię może zawierać tylko litery, spacje i myślniki">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nazwisko*</label>
                    <input type="text" name="surname" 
                           class="form-control @error('surname') is-invalid @enderror" 
                           value="{{ old('surname', $dentist->surname) }}" 
                           required
                           pattern="[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s-]+"
                           title="Nazwisko może zawierać tylko litery, spacje i myślniki">
                    @error('surname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Specjalizacja*</label>
                    <input type="text" name="specialization" 
                           class="form-control @error('specialization') is-invalid @enderror" 
                           value="{{ old('specialization', $dentist->specialization) }}" 
                           required>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Numer licencji*</label>
                    <input type="text" name="license_number" 
                           class="form-control @error('license_number') is-invalid @enderror" 
                           value="{{ old('license_number', $dentist->license_number) }}" 
                           required
                           pattern="[A-Z0-9]+"
                           title="Numer licencji może zawierać tylko wielkie litery i cyfry">
                    @error('license_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Zdjęcie profilowe</label>
                    @if($dentist->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $dentist->image_path) }}" 
                                 alt="Aktualne zdjęcie" 
                                 class="rounded-circle"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" name="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/jpeg,image/png,image/jpg,gif">
                    <small class="text-muted">Maksymalny rozmiar: 2MB, wymiary: min 100x100px, max 2000x2000px</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            <a href="{{ route('dentist.dashboard') }}" class="btn btn-secondary">Anuluj</a>
        </div>
    </form>
    <a href="{{ route('dentist.totp') }}" class="btn btn-info mt-3">Aktywuj TOTP (Google Authenticator)</a>
</div>
@endsection