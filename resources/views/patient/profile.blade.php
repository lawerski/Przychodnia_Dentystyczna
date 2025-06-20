@extends('layouts.patient', ['pageTitle' => 'Panel Pacjent'])

@section('content')
<div class="container mt-4" style="max-width:500px;">
    <h2>Moje dane</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('patient.profile.update') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nazwa użytkownika</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Nowe hasło</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Potwierdź hasło</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </form>
    <a href="{{ route('patient.totp') }}" class="btn btn-info mt-3">Aktywuj TOTP (Google Authenticator)</a>
</div>
@endsection
