{{-- filepath: resources/views/admin/reservations/edit.blade.php --}}
@extends('layouts.admin', ['pageTitle' => 'Edytuj rezerwację'])

@section('content')
<div class="container mt-4" style="max-width: 600px;">
    <h2>Edytuj rezerwację</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">Użytkownik</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($reservation->user_id == $user->id) selected @endif>
                        {{ $user->username }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="service_id" class="form-label">Usługa</label>
            <select name="service_id" id="service_id" class="form-select" required>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" @if($reservation->service_id == $service->id) selected @endif>
                        {{ $service->service_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="date_time" class="form-label">Data i godzina</label>
            <input type="datetime-local" name="date_time" id="date_time" class="form-control"
                   value="{{ old('date_time', \Carbon\Carbon::parse($reservation->date_time)->format('Y-m-d\TH:i')) }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="oczekująca" @if($reservation->status == 'oczekująca') selected @endif>Oczekująca</option>
                <option value="potwierdzona" @if($reservation->status == 'potwierdzona') selected @endif>Potwierdzona</option>
                <option value="anulowana" @if($reservation->status == 'anulowana') selected @endif>Anulowana</option>
                <option value="wykonana" @if($reservation->status == 'wykonana') selected @endif>Wykonana</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Zapisz zmiany</button>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary ms-2">Anuluj</a>
    </form>
</div>
@endsection
