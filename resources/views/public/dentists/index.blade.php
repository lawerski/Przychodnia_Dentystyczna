@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Nasi Dentyści</h2>

    <!-- Search and Filter Form -->
    <form action="{{ route('dentists.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Szukaj po imieniu, nazwisku lub specjalizacji..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="specialization" class="form-select">
                    <option value="">Wszystkie specjalizacje</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>
                            {{ $spec }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="surname" {{ request('sort') == 'surname' ? 'selected' : '' }}>
                        Sortuj po nazwisku
                    </option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                        Sortuj po imieniu
                    </option>
                    <option value="specialization" {{ request('sort') == 'specialization' ? 'selected' : '' }}>
                        Sortuj po specjalizacji
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtruj</button>
            </div>
        </div>
    </form>

    <!-- Dentists Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($dentists as $dentist)
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    @if($dentist->image_path)
                        <img src="{{ asset('storage/' . $dentist->image_path) }}" 
                             class="card-img-top mb-3 rounded-circle mx-auto d-block"
                             alt="Zdjęcie {{ $dentist->name }}"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width: 150px; height: 150px;">
                            <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    
                    <h5 class="card-title text-center mb-3">
                        {{ $dentist->name }} {{ $dentist->surname }}
                    </h5>
                    <p class="card-text text-center text-muted mb-3">
                        {{ $dentist->specialization }}
                    </p>
                    <div class="text-center">
                        <a href="{{ route('dentists.show', $dentist) }}" 
                           class="btn btn-outline-primary">
                            Zobacz profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $dentists->links() }}
    </div>
</div>
@endsection