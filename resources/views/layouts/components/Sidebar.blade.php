<div class="sidebar-container">
    <ul class="sidebar">
        @if(Auth::user()->hasRole('admin'))
            <li>
                <a href="{{ route('backpack') }}">
                    <img src="{{ url('svg/sidebar/user.svg') }}" alt="" /><span>Administrácia</span>
                </a>
            </li>
        @endif
        <li>
            <a class="{{ Route::is('area.dog.*') ? 'active' : '' }}" href="{{ route('area.dog.index') }}">
                <img src="{{url('svg/sidebar/paw.svg')}}" alt=""><span>Moje psy</span>
            </a>
        </li>
        <li>
            <a class="{{ Route::is('area.event.*') ? 'active' : '' }}" href="{{ route('area.event.index') }}">
                <img src="{{url('svg/sidebar/medal.svg')}}" alt=""><span>Akcie</span>
            </a>
        </li>
        <li>
            <a class="{{ (request()->is('area/results*')) ? 'active' : '' }}" href="{{ route('area.results') }}">
                <img src="{{url('svg/sidebar/medal.svg')}}" alt=""><span>Výsledky</span>
            </a>
        </li>
        <li>
            <a class="{{ Route::is('area.station.*') ? 'active' : '' }}" href="{{ route('area.station.index') }}"><img
                    src="{{url('svg/sidebar/zippy.svg')}}" alt=""><span>Chovateľská stanica</span>
            </a>
        </li>
        <li>
            <a class="{{ Route::is('area.litters') ? 'active' : '' }}" href="{{ route('area.litters') }}">
                <img src="{{url('svg/sidebar/bone.svg')}}" alt=""><span>Vrhy</span>
            </a>
        </li>
        <li>
            <a class="{{ Route::is('area.profile.*') ? 'active' : '' }}" href="{{ route('area.profile.index') }}">
                <img src="{{url('svg/sidebar/user.svg')}}" alt=""><span>Môj účet</span>
            </a>
        </li>
        <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               href="{{ route('logout') }}"><img src="{{url('svg/sidebar/logout.svg')}}" alt=""><span>Odhlásiť sa</span></a>

        </li>
    </ul>
</div>
