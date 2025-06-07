<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dentist.dashboard') }}">Panel dentysty</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dentist.history') }}">Historia zabiegów</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dentist.upcoming') }}">Nadchodzące zabiegi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dentist.services') }}">Moje ofery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dentist.calendar') }}">Kalendarz zabiegów</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dentist.reviews') }}">Oceny</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @include('shared.navbar_back')
                @include('shared.navbar_dropdown')
                @include('shared.navbar_theme')
            </ul>
        </div>
    </div>
</nav>
