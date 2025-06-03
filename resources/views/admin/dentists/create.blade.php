@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Dodaj nowego dentystę</h2>

    <form method="POST" action="{{ route('admin.dentists.store') }}" class="mt-4">
        @csrf
        
        <h4>Dane konta</h4>
        <div class="mb-3">
            <label class="form-label">Nazwa użytkownika</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Hasło</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Telefon</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <h4 class="mt-4">Dane zawodowe</h4>
        <div class="mb-3">
            <label class="form-label">Imię</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nazwisko</label>
            <input type="text" name="surname" class="form-control" value="{{ old('surname') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Specjalizacja</label>
            <input type="text" name="specialization" class="form-control" value="{{ old('specialization') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Numer licencji</label>
            <input type="text" name="license_number" class="form-control" value="{{ old('license_number') }}" required>
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

        <button type="submit" class="btn btn-success">Zapisz</button>
        <a href="{{ route('admin.dentists.index') }}" class="btn btn-secondary">Anuluj</a>
    </form>
</div>
@endsection