@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">@if(Route::is('public.owners')) Prehliadaj majiteľov @else Výsledok hľadania majiteľov @endif</h2>
                    <hr class="blue-hr mb-5">
                </section>

                @if(Route::is('public.owners'))
                    <div class="alphabet-container">
                        @foreach(\App\Models\Country::alphabet as $key => $letter)
                            <button><a href="{{ route('public.owners', ['startsWith' => $letter]) }}" style="color: inherit !important;">{{ $letter }}</a></button>
                        @endforeach
                    </div>

                    <form action="{{ route('public.owners') }}">
                        <div class="d-flex justify-content-between">
                            <div>
                                Prehliadaj podľa: <select name="sortBy" id="search-by">
                                    @foreach(['last_name' => 'Priezvisko', 'municipality' => 'Kraj', 'county' => 'Okres', 'breedingStation' => 'Chov. stanice'] as $key => $value)
                                        <option value="{{ $key }}" @if(old('sortBy') == $key) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                Vyhľadaj: <input type="text" name="search" id="search-input" value="{{ old('search') ?? '' }}" />
                            </div>
                        </div>
                    </form>
                @endif

                @if(Route::is('public.search.owners.result'))
                    <div class="d-flex justify-content-start align-items-center my-3">
                        Nájdených {{ $owners->total() }} osôb podľa zadaných kritérií. Zobrazených {{ $owners->firstItem() }} - {{ $owners->lastItem() }}
                    </div>
                @endif
                <div class="table-responsive my-5">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Priezvisko:</th>
                            <th scope="col">Meno:</th>
                            <th scope="col">Obec:</th>
                            <th scope="col">Okres:</th>
                            <th scope="col">Kraj:</th>
                            <th scope="col">Plemeno:</th>
                            <th scope="col">Chov. stanica:</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($owners as $owner)
                            <tr>
                                <td><a class="blue-cell"
                                       href="{{ route('public.owner_profile', $owner->id) }}">{{ $owner->last_name ?? "-" }}</a>
                                </td>
                                <td>{{ $owner->first_name ?? "-" }}</td>
                                <td>{{ $owner->city ?? '-' }}</td>
                                <td>{{ $owner->county ?? "-" }}</td>
                                <td>{{ $owner->municipality ?? "-" }}</td>
                                <td>{{ $owner->dogs()->first()?->breed->code }}</td>
                                <td>{{ $owner->breedingStation ? $owner->breedingStation->name : '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section></section>
                    {{ $owners->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
