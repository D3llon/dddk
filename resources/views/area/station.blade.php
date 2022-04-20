@extends('layouts.area.app')
@php
    /** @var \App\Models\BreedingStation $station */
    /** @var \App\Models\User $user */
@endphp

@section('content')
    @include('area.components.WelcomeBar')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('layouts.components.Sidebar')
            </div>
            <div class="col-lg-9">

                <h2 class="text-center text-uppercase">Chovateľska stanica @if(isset($station))
                        - {{ $station->name }} @endif</h2>
                <hr class="blue-hr mb-5">

                @if(!isset($station))
                    <div class="alert alert-warning">
                        Nemáte zaregistrovanú žiadnu chovateľskú stanicu!
                    </div>
                @else
                    @if($station->status === 'pending' || $station->modifications->count() > 0)
                        <div class="alert alert-warning">
                            Nemáte schválené zmeny vo Vašej chovateľskej stanici!
                        </div>
                    @endif
                @endif

                <form action="{{ route('area.station.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="name" class="form-label">Názov chovateľskej stanice <span
                                    class="text-danger">*</span></label></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ isset($station) ? $station->name : old('name') }}" required/>
                        </div>

                        <div class="col-lg-6">
                            <label for="description" class="form-label">Popis</label>
                            <input type="text" class="form-control" id="description" name="description"
                                   value="{{ isset($station) ? $station->description : old('description') }}"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6 custom-checkbox">
                            <div class="control-group">
                                <label class="control control-checkbox">
                                    Stanica má chránený názov
                                    <input type="checkbox" name="has_protected_name" id="has_protected_name" @if(isset($station) && $station->has_protected_name) checked @endif />
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
{{--                            <section>--}}
{{--                                <div class="col-12 mb-3">--}}
{{--                                    <label for="documents" class="form-label">Dokumenty</label>--}}
                            <input type="file" class="form-control" name="documents[]" id="documents"
                                   accept="image/png, image/jpeg, application/pdf" multiple hidden/>
{{--                                </div>--}}
                            <div class="document-container">
                                @if(isset($station))
                                    @foreach($station->documents as $document)
                                        <div class="station-document">
                                            {{ $document->name }}
                                            <button class="station-document-delete"></button>
                                        </div>
                                    @endforeach
                                @endif

                                <button id="document-button" class="add-document">
                                    <img src="{{url('svg/plus.svg')}}" alt="">
                                    <span>Nahrať dokument</span>
                                </button>
                            </div>
{{--                            </section>--}}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <hr class="blue-hr my-5">
                        </div>
                    </div>

                        @if(isset($station))
                            <div class="row mb-3">
                                <div class="col-12"><p>Pre priradenie psov do Vašej chovateľskej stanice je potrebné pridať
                                        psov do
                                        sekcie „MOJE PSY”</p>
                                </div>

{{--                                <div class="col-12">--}}
{{--                                    <select class="my-3" name="#" id="#">--}}
{{--                                        <option value="#">Vyberte psa z Vašej databázy</option>--}}
{{--                                        @foreach($user->dogs as $dog)--}}
{{--                                            <option value="{{ $dog->id }}">{{ $dog->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-12"><a style="color: black" href="{{ route('area.dog.add') }}" class="d-flex flex-row align-items-center gap-2"><img--}}
{{--                                        src="{{ url('svg/plus_black.svg') }}"  alt=""> Priradiť ďalšieho psa</a></div>--}}
                            </div>
                        @endif

                        @if(isset($station) && ($station->modifications->count() > 0 || $station->status === 'pending'))
                            <div class="alert alert-warning">
                                Nemáte schválené zmeny vo Vašej chovateľskej stanici!
                            </div>
                        @else
                            <div class="col-12 ">
                                <div class="text-center">
                                    <button type="submit">Odoslať na schválenie</button>
                                </div>
                            </div>
                        @endif

                    </div>
                </form>
            </div>
        </div>
        @endsection

        @push('js')
            <script>

                function handleDocumentClick(e) {
                    e.preventDefault()
                    console.log('click')
                    document.getElementById('documents').click()
                }

                document.onload = function () {
                    document.getElementById('document-button').addEventListener('click', handleDocumentClick)
                }
            </script>
    @endpush
