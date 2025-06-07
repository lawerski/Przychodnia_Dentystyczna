@extends('layouts.admin', ['pageTitle' => 'Użytkownicy'])

@section('content')
<div class="container mt-4">
    <h2>Edytuj użytkownika</h2>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nazwa użytkownika</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Hasło</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Typ</label>
            <select name="type" class="form-select">
                <option value="admin" @if($user->type=='admin') selected @endif>Admin</option>
                <option value="dentist" @if($user->type=='dentist') selected @endif>Dentysta</option>
                <option value="patient" @if($user->type=='patient') selected @endif>Pacjent</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Zapisz zmiany</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Powrót</a>
    </form>
</div>
@endsection
