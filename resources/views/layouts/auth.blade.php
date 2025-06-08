@include('shared.html')
@include('shared.head', ['pageTitle' => $pageTitle ?? 'Przychodnia Dentystyczna'])

<body>
    <div class="fill-view-port" style="min-height: 95vh;">
    @include('shared.guest.navbar')

    @yield('content')

    </div>
    @include('shared.footer', ['fixedBottom' => ''])
</body>
</html>
