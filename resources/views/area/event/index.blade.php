@extends('layouts.area.app')

@section('content')
    @include('area.components.WelcomeBar')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('layouts.components.Sidebar')
            </div>
            <div class="col-lg-9">
                <div class="mb-5"></div>
                <h2 class="text-center text-uppercase">Nasledujúce Akcie</h2>
                <hr class="blue-hr">

                @if($events)
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            <div class="results-container">
                                @foreach($events as $event)
                                    <div class="result_card d-flex flex-column flex-lg-row">
                                        <div class="left">
                                            <span>
                                                {{ \Carbon\Carbon::parse($event->date_from)->format('d.m.Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($event->date_to)->format('d.m.Y') }}
                                            </span>
                                        </div>
                                        <div class="middle">
                                            {{ $event->name }}
                                        </div>
                                        <div class="right">
                                            @if($event->registration_deadline <= \Carbon\Carbon::now())
                                                <span>Registrácie uzatvorené</span>
                                            @elseif($event->eventRegistrations()->whereRelation('user', 'id', Auth::id())->first() !== null)
                                                <span>Už ste sa registrovali!</span>
                                            @else
                                                <a href="{{ route('area.event.sign-form', ['id' => $event->id]) }}">Prihlásenie</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if($pastEvents)
                    <h2 class="text-center text-uppercase">Ukončené akcie</h2>
                    <hr class="blue-hr mb-3">

                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            <div class="results-container">
                                @foreach($pastEvents as $pastEvent)
                                    <div class="result_card d-flex flex-column flex-lg-row">
                                        <div class="left">
                                            {{ \Carbon\Carbon::parse($pastEvent->date_from)->format('d.m.Y') }}
                                        </div>
                                        <div class="middle">
                                            {{ $pastEvent->name }}
                                        </div>
                                        <div class="right">
                                            <a href="#">Výsledky</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
