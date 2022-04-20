@extends('layouts.area.app')

@section('content')
    <ul class="nav nav-pills nav-justified mb-4">
        <li class="nav-item">
            <a href="{{ route('area.profile.index') }}" class="nav-link {{ request()->routeIs('area.profile') ? 'active' : '' }}">
                Môj profil
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('area.dog.index') }}" class="nav-link {{ request()->routeIs('area.dog.*') ? 'active' : '' }}">
                Moji psi
            </a>
        </li>
    </ul>
    @yield('body')
@endsection
