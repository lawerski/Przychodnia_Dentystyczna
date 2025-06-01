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
                    <a class="nav-link" href="{{ route('dentist.reviews') }}">Oceny</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="">
                        <i class="bi bi-arrow-bar-left"></i> Wróć na stronę główną
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    {{-- TODO: Add auth --}}
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('dentist.dashboard') }}">Panel Dentysty</a></li>
                        <li><a class="dropdown-item" href="">Wyloguj</a></li>
                    </ul>
                </li>
                <li class="pr-5">
                    <button class="nav-link" onclick="themeToggle()"> <i class="bi-moon-stars"></i></button>
                </li>
            </ul>
        </div>
    </div>
</nav>
