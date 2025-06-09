@extends('layouts.main', ['pageTitle' => 'Przychodnia Dentystyczna'])

@section('content')

<div class="container mt-5 mb-5">
    <div class="row align-items-center mb-4">
        <div class="col-12">
            <h1 class="mt-4 w-100 text-start">Profil Dentysty</h1>
            <p class="text-start">Witaj na profilu dentysty!</p>
            <div class="card mb-4">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-start">
                        <div class="me-4">
                            @if($dentist->image_path)
                                <img src="{{ asset('storage/' . $dentist->image_path) }}"
                                     class="img-fluid rounded-circle mb-3"
                                     alt="Zdjęcie {{ $dentist->name }}"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mb-3"
                                     style="width: 120px; height: 120px;">
                                    <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="card-title mb-2" style="font-size: 2.5rem;">{{ $dentist->name }} {{ $dentist->surname }}</h3>
                            <p class="card-text mb-0 text-muted" style="font-size: 1.2rem;">
                                <i class="bi bi-award me-2"></i>Specjalizacja: {{ $dentist->specialization }}
                            </p>
                        </div>
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
        </div>
    </div>
    {{-- <div style="height: 12px;"></div> --}}
    <div class="row mt-4">
        <div class="col-12 mb-3">
            <h1 class="fw-semibold">Opinie:</h1>
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif

            @if($canReview)
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('dentists.addReview', $dentist) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="rating" class="form-label">Ocena:</label>
                            <select name="rating" id="rating" class="form-select" required>
                                <option value="">Wybierz ocenę</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Komentarz:</label>
                            <textarea name="comment" id="comment" class="form-control" rows="3" required maxlength="1000" placeholder="Napisz swoją opinię..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Opublikuj</button>
                    </form>
                </div>
            </div>
            @endif
        </div>
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
