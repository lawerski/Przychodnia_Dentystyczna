@include('shared.html')

@include('shared.head', ['pageTitle' => 'Zabiegi dentystyczne'])

<body>
    @include('shared.dentist.navbar')
    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Zabiegi dentystyczne</h1>
        <p>W tej sekcji możesz przeglądać i zarządzać zabiegami dentystycznymi.</p>

        <div class="row">
            <div class="col-md-12">
                <h2>Lista zabiegów</h2>
                @if($services->isEmpty())
                    <p>Brak zabiegów do wyświetlenia.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nazwa zabiegu</th>
                                <th>Koszt</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $service->service_name }}</td>
                                    <td>{{ $service->cost }}</td>
                                    <td>
                                        <a href="{{ route('dentist.dashboard', $service->id) }}" class="btn btn-primary btn-sm">Edytuj</a>
                                        <form action="{{ route('dentist.dashboard', $service->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <a href="{{ route('dentist.dashboard') }}" class="btn btn-success">Dodaj nowy zabieg</a>
            </div>
        </div>
    @include('shared.footer')
</body>
</html>
