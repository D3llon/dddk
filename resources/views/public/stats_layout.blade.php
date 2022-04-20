@extends('layouts.public.app')

@php
    use App\Models\Dog;
    use App\Models\User;
    $dddkCount = Dog::where('dddk', 1)->count();
    $foreignCount = Dog::where('dddk', 0)->count();
    $userCount = User::count();
    $picCount = Dog::whereHas('photos')->count();
@endphp

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">Štatistiky</h2>
                    <hr class="blue-hr mb-2">
                    <p class="w-lg-50 mx-auto">
                        Momentálne je v databáze {{ $dddkCount ?? "-" }} psov uchovnených v
                        DDDK, {{ $foreignCount ?? "-" }} zahraničných psov
                        a {{ $userCount ?? "-"}} majiteľov psov.
                        {{ $picCount ?? "-" }} psov má v databáze aj svoju fotografiu.
                    </p>
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills mb-3 custom-pills _50-50-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('public.statistics-breeds') }}">
                            <button class="nav-link @if(Route::is('public.statistics-breeds')) active @endif no-underline">
                                Plemená psov
                            </button>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('public.statistics-owners') }}">
                            <button class="nav-link @if(Route::is('public.statistics-owners')) active @endif no-underline">
                                Majitelia
                            </button>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('public.statistics-stations') }}">
                            <button class="nav-link @if(Route::is('public.statistics-stations')) active @endif no-underline">
                                Chov. stanice členov klubu
                            </button>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('public.statistics-dddk') }}">
                            <button class="nav-link @if(Route::is('public.statistics-dddk')) active @endif no-underline">
                                Uchovnené psy v DDDK
                            </button>
                        </a>
                    </li>
                </ul>
                <section></section>
                <div class="tab-content" id="pills-tabContent">
                    @yield('body')
                </div>
            </div>
        </div>
    </div>
@endsection
