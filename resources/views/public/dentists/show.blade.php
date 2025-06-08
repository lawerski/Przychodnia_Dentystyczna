
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="text-center mb-4">
                @if($dentist->image_path)
                    <img src="{{ asset('storage/' . $dentist->image_path) }}" 
                         class="img-fluid rounded-circle mb-3"
                         alt="Zdjęcie {{ $dentist->name }}"
                         style="width: 300px; height: 300px; object-fit: cover;">
                @else
                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                         style="width: 300px; height: 300px;">
                        <i class="bi bi-person-fill" style="font-size: 8rem;"></i>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-8">
            <h2>{{ $dentist->name }} {{ $dentist->surname }}</h2>
            <p class="text-muted mb-4">{{ $dentist->specialization }}</p>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h4>O dentyście</h4>
                    <dl class="row">
                        <dt class="col-sm-3">Imię i nazwisko</dt>
                        <dd class="col-sm-9">{{ $dentist->name }} {{ $dentist->surname }}</dd>
                        
                        <dt class="col-sm-3">Specjalizacja</dt>
                        <dd class="col-sm-9">{{ $dentist->specialization }}</dd>
                        
                        <dt class="col-sm-3">Numer licencji</dt>
                        <dd class="col-sm-9">{{ $dentist->license_number }}</dd>
                    </dl>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('dentists.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Powrót do listy dentystów
                </a>
            </div>
        </div>
    </div>
</div>
@endsection