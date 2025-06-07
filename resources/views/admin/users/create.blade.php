@extends('layouts.admin', ['pageTitle' => 'Użytkownicy'])

@section('content')
<div class="container mt-4">
    <h2>Dodaj użytkownika</h2>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nazwa użytkownika</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Hasło</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Typ</label>
            <select name="type" class="form-select">
                <option value="admin">Admin</option>
                <option value="dentist">Dentysta</option>
                <option value="patient">Pacjent</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Zapisz</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Powrót</a>
    </form>
</div>
@endsection
