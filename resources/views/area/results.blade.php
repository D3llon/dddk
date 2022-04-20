@extends('layouts.area.app')

@section('content')
    @include('area.components.WelcomeBar')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('layouts.components.Sidebar')
            </div>
            <div class="col-lg-9">

                <h2 class="text-center text-uppercase">Výsledky</h2>
                <hr class="blue-hr">
                <ul class="nav nav-pills mb-3 single-row-nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active no-underline" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Skúšky
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link no-underline" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">Výstavy
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                         aria-labelledby="pills-home-tab">
                        <div class="results-container">

                            <div class="result_card d-flex flex-column flex-lg-row">
                                <div class="left">
                                    30.5.2021
                                </div>
                                <div class="middle">
                                    OVVR l.c.
                                </div>
                                <div class="right">
                                    <a href="#">Zobraziť výsledky</a>
                                </div>
                            </div>

                            <div class="result_card d-flex flex-column flex-lg-row">
                                <div class="left">
                                    30.5.2021
                                </div>
                                <div class="middle">
                                    OVVR l.c.
                                </div>
                                <div class="right">
                                    <a href="#">Zobraziť výsledky</a>
                                </div>
                            </div>

                            <div class="result_card d-flex flex-column flex-lg-row">
                                <div class="left">
                                    30.5.2021
                                </div>
                                <div class="middle">
                                    OVVR l.c.
                                </div>
                                <div class="right">
                                    <a href="#">Zobraziť výsledky</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="results-container">

                            <div class="result_card d-flex flex-column flex-lg-row">
                                <div class="left">
                                    30.5.2021
                                </div>
                                <div class="middle">
                                    OVVR l.c.
                                </div>
                                <div class="right">
                                    <a href="#">Zobraziť výsledky</a>
                                </div>
                            </div>

                            <div class="result_card d-flex flex-column flex-lg-row">
                                <div class="left">
                                    30.5.2021
                                </div>
                                <div class="middle">
                                    OVVR l.c.
                                </div>
                                <div class="right">
                                    <a href="#">Zobraziť výsledky</a>
                                </div>
                            </div>

                            <div class="result_card d-flex flex-column flex-lg-row">
                                <div class="left">
                                    30.5.2021
                                </div>
                                <div class="middle">
                                    OVVR l.c.
                                </div>
                                <div class="right">
                                    <a href="#">Zobraziť výsledky</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
