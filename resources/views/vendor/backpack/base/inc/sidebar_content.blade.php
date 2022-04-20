<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-title">Psi</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('breed') }}'><i class='nav-icon la la-paw'></i> Plemená</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('breeding-station') }}'><i class='nav-icon la la-home'></i> Chovateľské stanice</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('dog') }}'><i class='nav-icon las la-dog'></i> Psi</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('litter') }}'><i class='nav-icon la la-bone'></i> Vrhy</a></li>

<li class="nav-title">Udalosti</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('event') }}'><i class='nav-icon la la-calendar-o'></i> Udalosti</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('event-registration') }}'><i class='nav-icon la la-pen'></i> Registrácie na udalosti</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('event-type') }}'><i class='nav-icon la la-cog'></i> Typy udalostí</a></li>

<li class="nav-title">Fotky</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('photo') }}'><i class='nav-icon la la-images'></i> Fotky</a></li>

<li class="nav-title">Prehľady</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('member') }}'><i class='nav-icon la la-users'></i> Členovia</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('dog-photo') }}'><i class='nav-icon la la-image'></i> Fotky psov</a></li>

{{--<li class="nav-item nav-dropdown">--}}
{{--    <a class="nav-link nav-dropdown-toggle" href="#"><i class="la la-file-alt"></i> Prehľady</a>--}}
{{--    <ul class="nav-dropdown-items">--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user-dog') }}'><i class='nav-icon la la-list'></i> Majitelia psov</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user-breed') }}'><i class='nav-icon la la-list'></i> Majitelia plemien</a></li>--}}
{{--        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user-breeding-station') }}'><i class='nav-icon la la-list'></i> Majitelia chovateľských staníc</a></li>--}}

{{--    </ul>--}}
{{--</li>--}}

<li class="nav-title">Schvaľovanie</li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('creation') }}"><i class="nav-icon la la-list"></i> Vytvorene</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('modification') }}"><i class="nav-icon la la-list"></i> Modifikácie</a></li>

<li class="nav-title">Nastavenia systému</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users-cog"></i> Administrácia prístupov</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="la la-user nav-icon"></i> Používatelia</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="la la-id-badge nav-icon"></i> Role</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="la la-key nav-icon"></i> Oprávnenia</a></li>
        {{--<li class='nav-item'><a class='nav-link' href='{{ backpack_url('personal-access-token') }}'><i class='nav-icon la la-question'></i> Personal access tokens</a></li>--}}
    </ul>
</li>
