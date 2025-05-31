
@if (session('accepted'))
    <div class="alert alert-success fade-message" role="alert" onclick="this.remove()">
        {{ session('accepted') }}
    </div>
@endif
@if (session('rejected'))
    <div class="alert" style="background-color: #ffc107; color: #212529;" role="alert" onclick="this.remove()">
        {{ session('rejected') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger fade-message" role="alert" onclick="this.remove()">
        {{ session('error') }}
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
                <th>Akceptuj</th>
                <th>Odrzuć</th>
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
                                <button type="submit" class="btn btn-primary btn-sm px-2 py-1">Akceptuj</button>
                            </form>
                        </td>
                        <td class="p-1 align-middle">
                            <form action="{{ route('reservation.decline', ['reservation' => $procedure['reservation']]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm px-2 py-1">Odrzuć</button>
                            </form>
                        </td>
                    @else
                        <td class="p-1 align-middle"></td>
                        <td class="p-1 align-middle"></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
