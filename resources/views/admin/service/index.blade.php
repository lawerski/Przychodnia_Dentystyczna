@extends('layouts.admin', ['pageTitle' => 'Zabiegi'])

<style>
    .hover-unmuted {
        color: #6c757d;
        transition: color 0.2s;
    }
    a:hover .hover-unmuted {
        color: inherit;
    }
</style>

@section('content')

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h2>Zabiegi</h2>
    <a href="{{ route('service.create') }}" class="btn btn-success mb-3">
        Dodaj nowy zabieg
    </a>
    <form method="GET" action="{{ route('service.index') }}" class="row g-3 mb-4">
        <div class="col-md-3 d-flex align-items-end">
            <input type="text" name="service_name" class="form-control" placeholder="Nazwa zabiegu" value="{{ request('service_name') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <select name="dentist_id" class="form-select">
                <option value="">Wszyscy dentyści</option>
                @foreach($dentists as $dentist)
                    <option value="{{ $dentist->id }}" {{ request('dentist_id') == $dentist->id ? 'selected' : '' }}>
                        {{ $dentist->name }} {{ $dentist->surname }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-center">
            <label for="cost_max" class="form-label me-2 mb-0">Cena max:</label>
            <input type="range" class="form-range flex-grow-1 me-2" min="0" max="{{ $max_cost + 50 }}" step="10" id="cost_max" name="cost_max" value="{{ request('cost_max', $max_cost + 10 ) }}" oninput="document.getElementById('maxValue').innerText = this.value">
            <span id="maxValue" style="min-width: 60px; text-align: right; display: inline-block; margin-right: 4px;">{{ round(request('cost_max', $max_cost)) }}</span> zł
        </div>
        <div class="col-md-2 d-flex align-items-center justify-content-end">
            <button type="submit" class="btn btn-primary ms-2">Filtruj</button>
            <a href="{{ route('service.index') }}" class="btn btn-secondary ms-2">Wyczyść</a>
        </div>
    </form>
    @if($services->isEmpty())
        <div class="alert alert-info" role="alert">
            Brak zabiegów spełniających podane kryteria.
        </div>
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nazwa</th>
                <th>Dentysta</th>
                <th>Cena</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td class="align-middle">
                    <a href="{{ route('service.show', $service->id) }}" class="" style="cursor: pointer; text-decoration: none; color: inherit;">
                    <span class="hover-unmuted"><i class="bi bi-search"></i></span> {{ $service->service_name }}
                    </a>
                </td>
                <td class="align-middle">{{ $service->dentist->name.' '.$service->dentist->surname }}</td>
                <td class="align-middle">{{ $service->cost }} zł</td>
                <td class="align-middle">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('service.edit', $service->id) }}" class="btn btn-sm btn-primary me-2" title="Edytuj">
                            Edytuj
                        </a>
                        <form action="{{ route('service.delete', $service->id) }}" method="POST" style="display:inline-block; margin-bottom: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Usuń" style="margin-left: 9px;">
                                Usuń
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    {{ $services->links('pagination::bootstrap-5') }}
</div>
@endsection
