@extends('layouts.main', ['pageTitle' => 'Przychodnia Dentystyczna'])

@section('content')

<div class="container mt-5 mb-5">
    <h1 class="mt-4">Profil Dentysty</h1>
    <p>Witaj na profilu dentysty!</p>
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-1">{{ $dentist->name }} {{ $dentist->surname }}</h4>
                <p class="card-text mb-0">Specjalizacja: {{ $dentist->specialization }}</p>
            </div>
            <div class="text-end">
                <span class="display-4 fw-bold">
                    {{ number_format($average_rating, 2) }}/5
                </span>
                <div class="text-muted small">Średnia ocena</div>
                <div class="text-muted" style="font-size: 0.9rem;">
                    Liczba opinii: {{ $reviews_count }}
                </div>
            </div>
        </div>
    </div>
    <div style="height: 52px;"></div>
    <div class="row mt-4">
        @forelse($reviews as $review)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body position-relative">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title mb-2">Anonimowy użytkownik {{ $review['rating'] }}/5</h5>
                            <div class="text-muted small ms-2" style="white-space: nowrap;">
                                {{ \Carbon\Carbon::parse($review['created_at'])->format('Y-m-d') }}
                            </div>
                        </div>
                        <p class="card-text mt-3">{{ $review['comment'] }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Brak opinii do wyświetlenia.</div>
            </div>
        @endforelse
        {{ $reviews->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
