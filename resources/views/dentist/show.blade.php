@include('shared.html')

@include('shared.head', ['pageTitle' => 'Panel Dentysty'])

<body>
    @include('shared.dentist.navbar')

    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Panel Dentysty</h1>
        <p>Witaj w panelu dentysty! Tutaj możesz zarządzać swoimi zabiegami, przeglądać historię i nadchodzące zabiegi.</p>
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-1">{{ $dentist->name }} {{ $dentist->surname }}</h4>
                    <p class="card-text mb-0">Specjalizacja: {{ $dentist->specialization }}</p>
                </div>
                <div class="text-end">
                    <span class="display-4 fw-bold">{{ $upcoming_procedures_count }}</span>
                    <div class="text-muted small">Nadchodzące zabiegi</div>
                    <div class="text-muted" style="font-size: 0.9rem;">Ukończone: {{ $completed_procedures_count }}</div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h2>Nadchodzące zabiegi</h2>
                <p>Przeglądaj nadchodzące zabiegi i zarządzaj nimi.</p>
                <a href="{{ route('dentist.upcoming') }}" class="btn btn-primary">Zobacz nadchodzące zabiegi</a>
            </div>
            <div class="col-md-6">
                <h2>Historia zabiegów</h2>
                <p>Przeglądaj historię swoich zabiegów i oceniaj pacjentów.</p>
                <a href="{{ route('dentist.history') }}" class="btn btn-secondary">Zobacz historię zabiegów</a>
            </div>
        </div>
    </div>
    @include('shared.footer')
</body>
</html>
