
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            @if($dentist->image_path)
                <img src="{{ asset('storage/' . $dentist->image_path) }}" 
                     class="img-fluid rounded-circle mb-3"
                     alt="Zdjęcie {{ $dentist->name }}">
            @else
                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="height: 300px;">
                    <i class="bi bi-person-fill" style="font-size: 8rem;"></i>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <h2>{{ $dentist->name }} {{ $dentist->surname }}</h2>
            <p class="text-muted mb-4">{{ $dentist->specialization }}</p>
            
            <h4>O dentyście</h4>
            <p>Nr licencji: {{ $dentist->license_number }}</p>
            
            <a href="{{ route('dentists.index') }}" class="btn btn-secondary">
                Powrót do listy
            </a>
        </div>
    </div>
</div>
@endsection