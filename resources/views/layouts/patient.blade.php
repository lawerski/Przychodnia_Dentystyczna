@include('shared.html')
@include('shared.head', ['pageTitle' => $pageTitle ?? 'Przychodnia Dentystyczna'])

<body>
    <div class="fill-viewport" style="min-height: 95vh;">
    @include('shared.patient.navbar')

    @yield('content')
    </div>

    @include('shared.footer', ['fixedBottom' => ''])
</body>
</html>
