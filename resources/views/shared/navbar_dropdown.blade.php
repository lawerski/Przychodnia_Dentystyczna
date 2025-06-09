<li class="nav-item dropdown">
    @guest
        <a class="nav-link" href="{{ route('login') }}">
            <i class="bi bi-person-circle"></i>
        </a>
    @else
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            @if(Auth::user()->hasRole('patient'))
                <li><a class="dropdown-item" href="{{ route('patient.dashboard') }}">Panel Pacjenta</a></li>
            @elseif(Auth::user()->hasRole('dentist'))
                <li><a class="dropdown-item" href="{{ route('dentist.dashboard') }}">Panel Dentysty</a></li>
            @elseif(Auth::user()->hasRole('admin'))
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Panel Admina</a></li>
            @endif
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Wyloguj</button>
                </form>
            </li>
        </ul>
    @endguest
</li>

