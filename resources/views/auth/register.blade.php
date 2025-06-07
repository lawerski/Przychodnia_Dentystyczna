@extends('layouts.auth', ['pageTitle' => 'Rejestracja'])

@section('content')
<div class="container mt-4" style="max-width:400px;">
    <h2>Rejestracja</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nazwa użytkownika</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Hasło</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Potwierdź hasło</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Typ</label>
            <select name="type" class="form-select">
                <option value="patient">Pacjent</option>
                <option value="dentist">Dentysta</option>
            </select>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Zarejestruj</button>
    </form>
</div>
@endsection
