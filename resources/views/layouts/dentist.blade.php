@include('shared.html')
@include('shared.head', ['pageTitle' => $pageTitle ?? 'Panel Dentysty'])

<body>
    <div class="fill-viewport" style="min-height: 95vh;">
    @include('shared.dentist.navbar')

    @yield('content')
    </div>

    @include('shared.footer', ['fixedBottom' => ''])
</body>
</html>
