@extends('layouts.main', ['pageTitle' => 'Przychodnia Dentystyczna'])

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow p-4" style="min-width: 350px;">
        <h2 class="text-center mb-4">Witamy w przychodni dentystycznej</h2>
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('service.index') }}" class="btn btn-primary">Przeglądaj oferty</a>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Mój profil</a>
            @else
                @if(auth()->user()->hasRole('patient'))
                    <a href="{{ route('patient.dashboard') }}" class="btn btn-outline-secondary">Mój profil</a>
                @elseif(auth()->user()->hasRole('dentist'))
                    <a href="{{ route('dentist.dashboard') }}" class="btn btn-outline-secondary">Mój profil</a>
                @elseif(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Mój profil</a>
                @endif
            @endguest
        </div>
    </div>
</div>
@endsection
