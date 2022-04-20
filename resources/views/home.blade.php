@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.HomeJumbotronContent')

    <div class="container homepage">
        <div class="row">
            <div class="col-12">
                <h3 class="text-blue text-uppercase">Momentálne je v databáze <span
                        class="text-dark">{{ $dogCount }}</span> psov uchovnených v DDDK a <span
                        class="text-dark">{{ $userCount }}</span> majiteľov psov</h3>
                <p class="text-center mt-3">Táto databáza obsahuje zoznam psov uchovnených v DDDK, ako aj
                    ich predkov, ktorí uchovnení v klube nie sú. Nie všetci predkovia jedincov sú zadaní v
                    databáze DDDK, preto niektoré rodokmene nie sú kompletné. Priebežne budeme týchto psov
                    pridávať.</p>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-12">
                <div class="my-buttons">
                    <a href="{{ route('public.dogs') }}">Databáza psov</a>
                    <a href="{{ route('public.owners') }}">Databáza majiteľov</a>
                    <a href="{{ route('register') }}" class="brown">Žiadosť o členstvo</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="gray-container">
                    <div class="row content">
                        <div class="col-12 col-lg-3"></div>
                        <div class="col-12 col-lg-6">
                            <p>
                                Ak zistíte nezrovnalosti v databáze psov, prosím obráťte sa na hlavného
                                poradcu chovu
                                p.
                                Pochylého.
                            </p>
                            <h4>Pochylý Silvester</h4>
                            <h5>HLAVNÝ PORADCA CHOVU</h5>
                            <ul>
                                <li><img src="{{ asset('svg/location.svg') }}" alt="Adresa"> Petrova Ves 59, 908 44
                                    Petrova Ves
                                </li>
                                <li>
                                    <img src="{{ asset('svg/phone.svg') }}" alt="Telefon">
                                    +421 948 314 431
                                </li>
                                <li>
                                    <img src="{{ asset('svg/mail.svg') }}" alt="Mail"> <a
                                        href="mailto:silvester.pochyly@gmail.com">silvester.pochyly@gmail.com</a>
                                </li>
                            </ul>
                            <span>*žiadosti o uchovnenie, o vystavenie odporúčania na párenie,<br>
                            o zaslanie formulárov na zápis šteniat do SPKP, hlásenia vrhov</span>
                        </div>
                        <div class="col-12 col-lg-3">
                            <img class="conversation" src="{{ asset('svg/conversation.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
