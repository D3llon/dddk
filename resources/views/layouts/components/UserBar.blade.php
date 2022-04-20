<div class="userbar px-5">
    @auth

        <div class="d-flex justify-content-end">
            <img src="{{ url('svg/user.svg') }}" alt="user icon"> <span><a href="{{route('area.dog.index')}}">{{ auth()->user()->name }}</a></span>
        </div>
    @else
        <div class="d-flex justify-content-end">
            <img src="{{ url('svg/user.svg') }}" alt="user icon"> <span><a href="{{route('login')}}">Prihlásenie</a> / <a href="{{route('register')}}">Registrácia</a></span>
        </div>
    @endauth
</div>
