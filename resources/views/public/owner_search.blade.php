@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">Vyhľadávanie majiteľov:</h2>
                    <hr class="blue-hr mb-2">
                </section>

                <div class="search-container">

                    <form action="{{ route('public.search.owners.result') }}" class="login-form">

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Priezvisko:</label>
                            <input type="text" class="form-control"
                                   id="last_name" name="last_name"
                                   value="{{ old('last_name') }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="station" class="form-label">Chovateľská stanica:</label>
                            <input type="text" class="form-control"
                                   id="station" name="station"
                                   value="{{ old('station') }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">Obec:</label>
                            <input type="text" class="form-control"
                                   id="city" name="city"
                                   value="{{ old('city') }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="county" class="form-label">Okres:</label>
                            <input type="text" class="form-control"
                                   id="county" name="county"
                                   value="{{ old('county') }}" autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="municipality" class="form-label">Kraj:</label>
                            <select name="municipality" id="municipality">
                                <option value="">Všetky</option>
                                @foreach(\App\Models\Country::municipalities as $key => $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
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
