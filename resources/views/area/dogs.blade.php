@extends('layouts.area.app')
@section('title', 'Moje psy - ')

@section('content')
    @auth
        @include('area.components.WelcomeBar')
        <div class="container">

            <div class="row">
                <div class="col-lg-3">
                    @include('layouts.components.Sidebar')
                </div>
                <div class="col-lg-9 pr-5">
                    <h2 class="my-dogs">MOJE PSY</h2>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="dog-list">
                                @foreach($dogs as $dog)
                                    <div class="dog-card">
                                        <img
                                            src="/{{ $dog->photos->where('primary', true)->first()->path_thumb ?? '' }}"
                                            alt="Fotka psa {{ $dog->name }}">
                                        <span class="breed">{{$dog->breed->name}}</span>
                                        <a href="{{ route('public.dog_profile', $dog->id) }}" class="name">{{$dog->name}}</a>
                                        <a href="{{ route('area.dog.edit', ['id' => $dog->id]) }}" class="edit-dog">Upraviť údaje psa</a>
                                    </div>
                                @endforeach

                                <div class="add-dog-container">
                                    <a href="{{ route('area.dog.add') }}" class="add-dog">
                                        <img src="{{url('svg/plus.svg')}}" alt="">
                                        <span>Pridať psa</span>
                                    </a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nie ste prihlásený</div>

                <div class="card-body">
                    Prihláste sa prosím
                </div>
            </div>
        </div>
    @endauth
@endsection
