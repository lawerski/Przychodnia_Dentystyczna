@extends('layouts.main', ['pageTitle' => 'Zabiegi'])

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
    <?php
    if(session('success'))
        echo '<div class="alert alert-success">'.session('success').'</div>';
    if(session('error'))
        echo '<div class="alert alert-danger">'.session('error').'</div>';
    ?>
    <h2>Zabiegi</h2>
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
                <th></th>
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
                <td>{{ $service->dentist->name }} {{ $service->dentist->surname }}</td>
                <td>{{ $service->cost }} zł</td>
                <td>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-success btn-sm">Rezerwacja</a>
                    @else
                        @if(auth()->user()->type === 'patient')
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#reservationForm{{ $service->id }}">
                                Rezerwacja
                            </button>
                            <div class="collapse mt-2" id="reservationForm{{ $service->id }}">
                                <form action="{{ route('reservation.store') }}" method="POST" class="border rounded p-3 bg-light">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                                    <div class="mb-2">
                                        <label for="date_time_{{ $service->id }}" class="form-label">Wybierz termin</label>
                                        <input type="datetime-local" name="date_time" id="date_time_{{ $service->id }}" class="form-control mb-2" required>
                                        <select class="form-select" id="availableSlots_{{ $service->id }}" style="margin-top: 5px;">
                                            <option value="">Wybierz z dostępnych terminów...</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Zarezerwuj wizytę</button>
                                </form>
                            </div>
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                document.querySelectorAll('[data-bs-target^="#reservationForm"]').forEach(function(btn) {
                                    btn.addEventListener('click', function() {
                                        var serviceId = btn.getAttribute('data-bs-target').replace('#reservationForm', '');
                                        fetch(`/reservation/available-slots?service_id=${serviceId}`)
                                            .then(response => response.json())
                                            .then(slots => {
                                                var select = document.getElementById('availableSlots_' + serviceId);
                                                select.innerHTML = '<option value="">Wybierz z dostępnych terminów...</option>';
                                                slots.forEach(slot => {
                                                    select.innerHTML += `<option value="${slot}">${slot.replace('T', ' ')}</option>`;
                                                });
                                                // Po wybraniu slotu ustaw input datetime-local
                                                select.onchange = function() {
                                                    document.getElementById('date_time_' + serviceId).value = this.value;
                                                };
                                            });
                                    });
                                });
                            });
                            </script>
                        @endif
                    @endguest
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    {{ $services->links('pagination::bootstrap-5') }}
</div>

@endsection
