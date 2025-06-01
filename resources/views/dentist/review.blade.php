@include('shared.html')

@include('shared.head', ['pageTitle' => 'Oceny i opinie'])

<body>
    @include('shared.dentist.navbar')

    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Oceny i opinie</h1>
        <p>W tej sekcji można przeglądać opinie użytkowników.</p>
        <div class="row">
            <div class="col-md-8">
                <h2>Opinie</h2>
                @if($reviews->isEmpty())
                    <p>Brak opinii.</p>
                @else
                    @foreach($reviews as $review)
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span><strong>Anonimowy użytkownik {{ $review['rating'] }}/5</strong></span>
                                <small class="text-muted">{{ $review['created_at'] }}</small>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $review['comment'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @include('shared.footer')
</body>
</html>
