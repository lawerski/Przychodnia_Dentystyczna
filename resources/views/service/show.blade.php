@extends('layouts.main', ['pageTitle' => $service->service_name])

@section('content')

<div class="container mt-4">
    <div class="card shadow mb-4 p-4">
        <div class="card-body h-100 d-flex flex-column justify-content-center position-relative" style="min-height: 180px;">
            <div class="row align-items-center h-100">
                <div class="col-md-8 d-flex flex-column justify-content-center h-100">
                    <h5 class="card-title mb-3"><strong>Nazwa usługi:</strong> {{ $service->service_name }}</h5>
                    <p class="card-text"><strong>Dentysta:</strong> {{ $service->dentist->name }} {{ $service->dentist->surname }}</p>
                    <p class="card-text"><strong>Cena:</strong> {{ $service->cost }} zł</p>
                </div>
                <div class="col-md-4 d-flex flex-column justify-content-center align-items-md-end align-items-center h-100">
                    @if ($popularity > 8)
                        <span class="badge bg-warning text-dark fs-6 mb-3">
                            {{ $popularity }} zabiegów w ostatnim tygodniu!
                        </span>
                    @elseif ($popularity >= 2)
                        <span class="badge bg-primary fs-6 mb-3">
                            {{ $popularity }} zabiegów w ostatnim tygodniu.
                        </span>
                    @endif
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-success">Rezerwacja</a>
                    @else
                        <a href="#" class="btn btn-success">Rezerwacja</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        &larr; Powrót
    </a>
</div>

@endsection
