<nav class="navbar navbar-expand-lg px-3 px-lg-5">
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
                <a class="nav-link hover-blue" href="#">Úvod</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link hover-blue dropdown-toggle" href="#" id="navbarAbout" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    O klube
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarAbout">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link hover-blue dropdown-toggle" href="#" id="navbarBreeding" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Chovateľstvo
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarBreeding">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link hover-blue dropdown-toggle" href="#" id="navbarExhibitions" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Výstavy
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarExhibitions">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link hover-blue dropdown-toggle" href="#" id="navbarSport" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Šport
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarSport">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link hover-blue" href="#">Kalendár</a>
            </li>

            <li class="nav-item">
                <a class="nav-link hover-blue" href="#">Databáza</a>
            </li>


        </ul>
    </div>
</nav>

