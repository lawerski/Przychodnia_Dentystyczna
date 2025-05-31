@if (count($procedures) === 0)
    <div class="alert alert-info" role="alert">
        Brak zapisanych zabiegów.
    </div>
@else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Pacjent</th>
                <th>Zabieg</th>
                <th>Opis</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($procedures as $procedure)
                <tr>
                    <td>{{ $procedure['service'] }}</td>
                    <td>{{ $procedure['patient_name'] }}</td>
                    <td>{{ $procedure['date'] }}</td>
                    <td>{{ $procedure['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
