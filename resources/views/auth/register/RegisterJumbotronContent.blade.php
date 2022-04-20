@extends('auth.register.components.Jumbotron')

@section('jumbotron-content')
    <div class="content-container">
        <div class="content">
            <h2>PRIHLÁŠKA DO KLUBU</h2>
            <p>Prihlášku do klubu je možné vyplniť dvoma spôsobmi, a to vo forme online tlačiva,
                alebo pomocou vytlačenej prihlášky, ktorú je potrebné odoslať na adresu klubu.
                Online žiadosti vybavujeme prednostne do niekoľko pracovných dní.</p>
            <button class="button-full">Odoslať prihlášku</button>
            <button class="button-outline">Stiahnuť prihlášku</button>
        </div>
        <img class="dog-2" src="{{url('svg/dog.svg')}}" alt="">
    </div>
@endsection
