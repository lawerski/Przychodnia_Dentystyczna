@include('shared.html')
@include('shared.head', ['pageTitle' => $pageTitle ?? 'Panel Admina'])

<body>
    <div class="fill-view-port" style="min-height: 95vh;">
    @include('shared.admin.navbar')

    @yield('content')

    </div>
    @include('shared.footer', ['fixedBottom' => ''])
</body>
</html>
