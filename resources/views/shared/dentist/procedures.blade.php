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
                @if ($procedures->contains('status', 'oczekująca'))
                    <th>Akceptuj</th>
                    <th>Odrzuć</th>
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
                    {{-- Status pending does not appear in history --}}
                    @if ( $procedure['status'] === 'oczekująca')
                        <td class="p-1 align-middle">
                            {{-- TODO: Add route --}}
                            <a href="" class="btn btn-primary btn-sm px-2 py-1">Akceptuj</a>
                        </td>
                        <td class="p-1 align-middle">
                            <a href="" class="btn btn-danger btn-sm px-2 py-1">Odrzuć</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
