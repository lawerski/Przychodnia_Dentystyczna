@extends('layouts.dentist', ['pageTitle' => 'Panel Dentysty'])

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Panel Dentysty</h1>
        <p>Witaj w panelu dentysty! Tutaj możesz zarządzać swoimi zabiegami, przeglądać historię i nadchodzące zabiegi.</p>
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-1">{{ $dentist->name }} {{ $dentist->surname }}</h4>
                    <p class="card-text mb-0">Specjalizacja: {{ $dentist->specialization }}</p>
                    <a href="{{ route('dentist.profile.edit') }}" class="btn btn-secondary mt-3">Edytuj profil</a>
                </div>
                <div class="text-end">
                    <span class="display-4 fw-bold">{{ $upcoming_procedures_count }}</span>
                    <div class="text-muted small">Nadchodzące zabiegi</div>
                    <div class="text-muted" style="font-size: 0.9rem;">Ukończone: {{ $completed_procedures_count }}</div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h2>Nadchodzące zabiegi</h2>
                <p>Przeglądaj nadchodzące zabiegi i zarządzaj nimi.</p>
                <a href="{{ route('dentist.upcoming') }}" class="btn btn-primary">Zobacz nadchodzące zabiegi</a>
            </div>
            <div class="col-md-6">
                <h2>Historia zabiegów</h2>
                <p>Przeglądaj historię swoich zabiegów i oceniaj pacjentów.</p>
                <a href="{{ route('dentist.history') }}" class="btn btn-secondary">Zobacz historię zabiegów</a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Opinie i oceny</h2>
                <p>Przeglądaj opinie pacjentów na temat Twojej pracy.</p>
                <a href="{{ route('dentist.reviews') }}" class="btn btn-success">Zobacz opinie</a>
            </div>
        </div>
        <div class="row mt-4">
            @foreach($reviews as $review)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="card-title mb-2">Anonimowy użytkownik {{ $review['rating'] }}/5</h5>
                                <small class="text-muted" style="font-size: 0.9rem;">{{ $review['created_at'] }}</small>
                            </div>
                            <p class="card-text mt-3">{{ $review['comment'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
