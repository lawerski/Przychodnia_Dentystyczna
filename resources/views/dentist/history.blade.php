@include('shared.html')

@include('shared.head', ['pageTitle' => 'Historia zabiegów'])

<body>
    @include('shared.dentist.navbar')

    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Historia zabiegów</h1>
        <p>W tej sekcji możesz przeglądać historię swoich zabiegów.</p>

        @include('shared.dentist.procedures', ['procedures' => $procedures])
    </div>
    @include('shared.footer')
</body>
</html>
