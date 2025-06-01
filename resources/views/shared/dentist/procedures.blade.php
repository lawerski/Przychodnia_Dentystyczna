
@if (session('accepted'))
    <div class="alert alert-success container mt-4" id="success-alert">
        {{ session('accepted') }}
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('success-alert').remove();"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-success container mt-4" id="success-alert">
        {{ session('error') }}
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('success-alert').remove();"></button>
    </div>
@endif


@if (count($procedures) === 0)
    <div class="alert alert-info" role="alert">
        Brak zapisanych zabiegów.
    </div>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Zabieg</th>
                <th>Pacjent</th>
                <th>Data</th>
                <th>Status</th>
                @if (request()->routeIs('dentist.upcoming'))
                    <th>Akcja</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($procedures as $procedure)
                <tr>
                    <td>{{ $procedure['service_name'] }}</td>
                    <td>{{ $procedure['patient_name'] }}</td>
                    <td>{{ $procedure['date'] }}</td>
                    <td>
                        <span class="
                            badge
                            @if ($procedure['status'] === 'anulowana' || $procedure['status'] === 'odrzucona') bg-danger
                            @elseif ($procedure['status'] === 'wykonana') bg-info
                            @elseif ($procedure['status'] === 'oczekująca') bg-warning text-dark
                            @elseif ($procedure['status'] === 'potwierdzona') bg-success
                            @endif
                        ">
                            {{ $procedure['status'] }}
                        </span>
                    </td>
                    @if ( $procedure['status'] === 'oczekująca')
                        <td class="p-1 align-middle">
                            <form action="{{ route('reservation.accept', ['reservation' => $procedure['reservation']]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-primary btn-sm px-2 py-1">Potwierdź</button>
                            </form>
                        </td>
                    @else
                        <td class="p-1 align-middle"></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
