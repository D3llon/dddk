@extends('layouts.area.app')
@php
    /** @var \App\Models\Dog $dog */
@endphp

@section('content')
    @auth
        @include('area.components.WelcomeBar')
        <div class="container">

            <div class="row">
                <div class="col-lg-3">
                    @include('layouts.components.Sidebar')
                </div>
                <div class="col-lg-9 pr-5">
                    <h2 class="text-center">@if(isset($dog)) ŽIADOSŤ O UPRAVENIE PSA - {{ $dog->name }} @else ŽIADOSŤ O PRIDANIE PSA @endif</h2>

                    @if(isset($dog))
                        @if($dog->modifications->count() > 0)
                            <div class="alert alert-warning">
                                U tohto psa je evidovaná požiadavka o zmenu. Prosím, počkajte na schválenie!
                            </div>
                        @endif
                    @endif

                    <hr class="blue-hr hr-m-bottom">

                    <form action="{{ isset($dog) ? route('area.dog.edit', ['id' => $dog->id]) : route('area.dog.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="owner" class="form-label">Majiteľ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="owner"
                                       value="{{ $user->name }}" disabled/>
                            </div>
                            <div class="col-lg-6">
                                <label for="coowner" class="form-label">Spolumajiteľ</label>
                                <input type="text" class="form-control" name="coowner" id="coowner"
                                       value="{{ isset($dog) ? $dog->coowner : old('coowner') }}"/>
                            </div>
                        </div>

                        <hr class="blue-hr my-5">

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Meno psa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ isset($dog) ? $dog->name : old('name') }}" required/>
                            </div>

                            <div class="col-lg-6">
                                <label for="breed_id" class="form-label">Plemeno&nbsp;<span class="text-danger">*</span></label>
                                <select name="breed_id" id="breed_id" required>
                                    <option value=""></option>
                                    @foreach(\App\Models\Breed::where('id', '!=', 7)->get() as $breed)
                                        <option value="{{ $breed->id }}"
                                                @if(isset($dog) ? $dog->breed_id == $breed->id : old('breed_id') == $breed->id) selected @endif>{{ $breed->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="birth_year" class="form-label">Rok narodenia <span href="#"
                                                                                               class="text-danger">*</span><a
                                        class="custom-tooltip" title="4 číselný formát (napr. 2021)">?</a></label>
                                <input type="text" class="form-control" name="birth_year" id="birth_year"
                                       value="{{ isset($dog) ? $dog->birth_year : old('birth_year') }}" required/>
                            </div>

                            <div class="col-lg-6">
                                <label for="sex" class="form-label">Pohlavie&nbsp;<span
                                        class="text-danger">*</span></label>
                                <select name="sex" id="sex" required>
                                    <option value=""></option>
                                    @foreach(['M' => 'pes', 'F' => 'suka'] as $key => $value)
                                        <option value="{{ $key }}"
                                                @if(isset($dog) ? $dog->sex == $key : old('sex') == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-6 custom-checkbox">
                                <div class="control-group">
                                    <label class="control control-checkbox">
                                        Úhyn psa
                                        <input type="checkbox" name="death" id="death" @if(isset($dog) && $dog->deathdate) checked @endif />
                                        <div class="control_indicator"></div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row my-3" id="deathdate-div" @if(!isset($dog) || !$dog->deathdate) style="display: none" @endif>
                            <div class="col-lg-6">
                                <label for="deathdate" class="form-label">
                                    Rok úmrtia <a class="custom-tooltip" title="4 číselný formát (napr. 2021)">?</a></label>
                                <input type="text" class="form-control" name="deathdate" id="deathdate"
                                       value="{{ isset($dog) ? $dog->deathdate : old('deathdate') }}" />
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="color" class="form-label">Farba <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="color" id="color"
                                       value="{{ isset($dog) ? $dog->color : old('color') }}" required/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
{{--                                <label for="image" class="form-label">Obrázok</label>--}}
                                <input type="file" class="form-control" name="image" id="image"
                                       accept="image/png, image/jpeg" hidden multiple/>
                                <button id="image-button">Nahrať fotografie psa</button>

                                <ul id="img-list"></ul>
                            </div>
                            @if(isset($dog))
                                @foreach($dog->photos()->orderByDesc('primary')->get() as $photo)
                                    <div class="col-4">
                                        <img src="/{{ $photo->path_thumb ?? '' }}" alt="" />
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <hr class="blue-hr my-5">

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="breeding_station_id" class="form-label">Chovateľská stanica</label>
{{--                                <input type="text" class="form-control" name="breeding_station_id" id="breeding_station_id"--}}
{{--                                       value="{{ isset($dog) ? $dog->breeding_station_id : old('breeding_station_id') }}" required/>--}}
                                <select name="breeding_station_id" id="breeding_station_id">
                                    <option value=""></option>
                                    @if($user->breedingStation)
                                        <option value="{{ $user->breedingStation->id }}">{{ $user->breedingStation->name }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="dddk" class="form-label">Uchovnený v DDDK&nbsp;<span class="text-danger">*</span></label>
                                <select name="dddk" id="dddk" required>
                                    <option value=""></option>
                                    @foreach([0 => 'Nie', 1 => 'Áno'] as $key => $value)
                                        <option value="{{ $key }}" @if(isset($dog) ? $dog->dddk == $key : old('skr') == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="sire_name" class="form-label">Otec <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="sire_name" id="sire_name"
                                       value="{{ isset($dog) ? $dog->sire_name : old('sire_name') }}" required/>
                            </div>
                            <div class="col-lg-6">
                                <label for="dam_name" class="form-label">Matka <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="dam_name" id="dam_name"
                                       value="{{ isset($dog) ? $dog->dam_name : old('dam_name') }}" required/>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="hd" class="form-label">HD <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="hd" id="hd"
                                       value="{{ isset($dog) ? $dog->hd : old('hd') }}" required/>
                            </div>
                            <div class="col-lg-6">
                                <label for="ed" class="form-label">ED <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ed" id="ed"
                                       value="{{ isset($dog) ? $dog->ed : old('ed') }}" required/>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="eyes" class="form-label">Oči <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="eyes" id="eyes"
                                       value="{{ isset($dog) ? $dog->eyes : old('eyes') }}" required/>
                            </div>
                            <div class="col-lg-6">
                                <label for="eic" class="form-label">EIC <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="eic" id="eic"
                                       value="{{ isset($dog) ? $dog->eic : old('eic') }}" required/>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-lg-6">
                                <label for="shows" class="form-label">Výstavy</label>
                                <input type="text" class="form-control" name="shows" id="shows"
                                       value="{{ isset($dog) ? $dog->shows : old('shows') }}" />
                            </div>
                            <div class="col-lg-6">
                                <label for="exams" class="form-label">Skúšky</label>
                                <input type="text" class="form-control" name="exams" id="exams"
                                       value="{{ isset($dog) ? $dog->exams : old('exams') }}" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
{{--                                <label for="documents" class="form-label">Dodatkové dokumenty</label>--}}
                                <input type="file" class="form-control" name="documents[]" id="documents"
                                       accept="image/png, image/jpeg, application/pdf" multiple hidden/>
                                <button id="document-button">Nahrať dodatkové dokumenty</button>
                                <ul id="doc-list"></ul>
                            </div>
                            @if(isset($dog))
                                @foreach($dog->documents as $document)
                                    <div class="col-4">
                                        <span class="text-info">{{ $document->name }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @if(isset($dog))
                            <hr class="blue-hr my-5">

                            <div class="row my-3">
                                <div class="col-6 custom-checkbox">
                                    <div class="control-group">
                                        <label class="control control-checkbox">
                                            Chcem vytvoriť rodokmeň
                                            <input type="checkbox" name="family_tree"/>
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        @endif

                        @if(isset($dog) && $dog->modifications->count() > 0)
                            <div class="alert alert-warning">
                                U tohto psa je evidovaná požiadavka o zmenu. Prosím, počkajte na schválenie!
                            </div>
                        @else
                            <div class="d-flex justify-content-center my-5">
                                <button type="submit">Odoslať žiadosť</button>
                            </div>
                        @endif

                    </form>

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

@push("js")
    <script>
        let docs = [];
        function handleClickImage(e) {
            e.preventDefault()
            document.getElementById('image').click()
        }

        function handleClickDocument(e) {
            e.preventDefault()
            document.getElementById('documents').click()
        }

        function handleDocumentChange(e) {
            let list = []
            Array.from(document.getElementById('documents').files).forEach(file => {
                list.push(`<li>${file.name}</li>`)
            })
            $("#doc-list").empty().append(list)
        }

        function handleImageChange(e) {
            let list = []
            Array.from(document.getElementById('image').files).forEach(file => {
                console.log(file)
                list.push(`<li>${file.name}</li>`)
            })
            $("#img-list").empty().append(list)
        }

        window.onload = function() {
            document.getElementById('image-button').addEventListener('click', handleClickImage)
            document.getElementById('document-button').addEventListener('click', handleClickDocument)
            document.getElementById('documents').addEventListener('change', handleDocumentChange)
            document.getElementById('image').addEventListener('change', handleImageChange)
        }

        $(document).ready(function () {
            $('#death').click(function(){
                var val = $(this).attr("value");
                $("#deathdate-div").toggle();
            });

            $('#breed_id').select2({
                width: '100%',
                minimumResultsForSearch: -1,
                placeholder: 'Vyberte'
            })

            $('#sex').select2({
                width: '100%',
                minimumResultsForSearch: -1,
                placeholder: 'Vyberte'
            })

            $('#breeding_station_id').select2({
                width: '100%',
                minimumResultsForSearch: -1,
                placeholder: 'Vyberte'
            })

            $('#dddk').select2({
                width: '100%',
                minimumResultsForSearch: -1
            });
        })

    </script>
@endpush
