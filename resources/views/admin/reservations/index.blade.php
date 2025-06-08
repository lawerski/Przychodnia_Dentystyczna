{{-- filepath: resources/views/admin/reservations/index.blade.php --}}
@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h1 class="mb-4">Rezerwacje</h1>
    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary mb-3">Dodaj rezerwację</a>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Użytkownik</th>
                    <th>Usługa</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->id }}</td>
                    <td>{{ $reservation->user->username ?? '' }}</td>
                    <td>{{ $reservation->service->service_name ?? '' }}</td>
                    <td>{{ $reservation->date_time }}</td>
                    <td>
                        <span class="badge
                            @if($reservation->status === 'potwierdzona') bg-success
                            @elseif($reservation->status === 'oczekująca') bg-warning text-dark
                            @else bg-secondary
                            @endif">
                            {{ $reservation->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-info me-1">Pokaż</a>
                        <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-sm btn-warning me-1">Edytuj</a>
                        <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Na pewno usunąć?')">Usuń</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
