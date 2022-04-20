<nav class="navbar navbar-expand-lg px-5">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ url('/svg/logo.svg') }}" alt="DDDK Logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Domov</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('home') }}">Úvod</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('dogs*')) ? 'active' : '' }}" href="{{ route('public.dogs') }}">Jedince</a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ (request()->is('owners*')) ? 'active' : '' }}" href="{{ route('public.owners') }}">Majitelia</a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('litters*')) ? 'active' : '' }}" href="{{ route('public.litters') }}">Vrhy</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link {{ (request()->is('*search')) ? 'active' : '' }} dropdown-toggle" href="#" id="dropdown_search" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Hľadaj
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdown_search">
                    <li><a class="dropdown-item" href="{{ route('public.search.dog') }}">Jedince</a></li>
                    <li><a class="dropdown-item" href="{{ route('public.search.owner') }}">Majitelia</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('statistics*')) ? 'active' : '' }}" href="{{ route('public.statistics') }}">Štatistiky</a>
            </li>




        </ul>
    </div>
</nav>
