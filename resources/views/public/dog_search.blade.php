@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">Hľadaj jedince podľa zadaných kritérií:</h2>
                    <hr class="blue-hr mb-2">
                </section>

                <div class="search-container">
                    <form action="{{ route('public.search.dogs.result') }}" class="login-form">

                        <div class="mb-3">
                            <label for="name" class="form-label">Meno jedinca:</label>
                            <input type="text" class="form-control"
                                   id="name" name="name"
                                   value="{{ old('name') }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="station" class="form-label">Chovateľská stanica:</label>
                            <input type="text" class="form-control"
                                   id="station" name="station"
                                   value="{{ old('station') }}" autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="breed_id" class="form-label">Plemeno:</label>
                            <select name="breed_id" id="breed_id">
                                <option value="">Všetky</option>
                                @foreach(\App\Models\Breed::all() as $breed)
                                    <option value="{{ $breed->id }}">{{ $breed->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="sex" class="form-label">Pohlavie:</label>
                            <select name="sex" id="sex">
                                <option value="">oboje</option>
                                <option value="M">pes</option>
                                <option value="F">suka</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="HD" class="form-label">HD (RTG DBK):</label>
                            <select name="HD" id="HD">
                                <option value="">Všetky</option>
                                <option value="A/A">A/A</option>
                                <option value="A/B">A/B</option>
                                <option value="A/C">A/C</option>
                                <option value="B/A">B/A</option>
                                <option value="B/B">B/B</option>
                                <option value="B/C">B/C</option>
                                <option value="C/A">C/A</option>
                                <option value="C/B">C/B</option>
                                <option value="C/C">C/C</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ED" class="form-label">ED (RTG DLK):</label>
                            <select name="ED" id="ED">
                                <option value="">Všetky</option>
                                <option value="0/0">0/0</option>
                                <option value="0/1">0/1</option>
                                <option value="0/2">0/2</option>
                                <option value="1/0">1/0</option>
                                <option value="1/1">1/1</option>
                                <option value="1/2">1/2</option>
                                <option value="2/0">2/0</option>
                                <option value="2/1">2/1</option>
                                <option value="2/2">2/2</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="EIC" class="form-label">EIC:</label>
                            <select name="EIC" id="EIC">
                                <option value="">Všetky</option>
                                <option value="N/N">N/N</option>
                                <option value="N/EIC">N/EIC</option>
                                <option value="EIC/EIC">EIC/EIC</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="eyes" class="form-label">Vyšetrenie očí:</label>
                            <select name="eyes" id="eyes">
                                <option value="">Všetky</option>
                                <option value="negat.">negatívne</option>
                                <option value="carrier">carrier</option>
                            </select>
                        </div>

                        <div class="custom-checkbox">
                            <div class="control-group">
                                <label class="control control-checkbox">
                                    Iba s fotogragiou
                                    <input type="checkbox" name="has_image"/>
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                        </div>

                        <div class="custom-checkbox">
                            <div class="control-group">
                                <label class="control control-checkbox">
                                    Uchovnené v DDDK
                                    <input type="checkbox" name="dddk" checked/>
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                        </div>

                        <div class="submit-container">
                            <button type="submit">Vyhľadať</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
