@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">@if(Route::is('public.dogs')) Prehliadaj jedince @else Výsledok hľadania jedincov @endif</h2>
                    <hr class="blue-hr mb-5">
                </section>

                @if(Route::is('public.dogs'))
                    <div class="alphabet-container">
                        @foreach(\App\Models\Country::alphabet as $key => $letter)
                            <button><a href="{{ route('public.dogs', ['startsWith' => $letter]) }}" style="color: inherit !important;">{{ $letter }}</a></button>
                        @endforeach
                    </div>

                    <form action="{{ route('public.dogs') }}">
                        <div class="d-flex justify-content-between">
                            <div>
                                Prehliadaj podľa: <select name="sortBy" id="search-by">
                                    @foreach(['name' => 'Meno jedinca', 'breed' => 'Plemeno', 'breedingStation' => 'Chov. stanica'] as $key => $value)
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

                @if(Route::is('public.search.dogs.result'))
                    <div class="d-flex justify-content-start my-3">
                        Nájdených {{ $dogs->total() }} jedincov (jedince) podľa zadaných kritérií. Zobrazených {{ $dogs->firstItem() }} - {{ $dogs->lastItem() }}
                    </div>
                @endif

                <div class="table-responsive my-5">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Meno:</th>
                            <th scope="col">Plemeno:</th>
                            <th scope="col">Pohlavie:</th>
                            <th scope="col">Chov. stanica:</th>
                            @if(Route::is('public.search.dogs.result'))
                                <th scope="col">Otec:</th>
                                <th scope="col">Matka:</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dogs as $dog)
                            <tr>
                                <td class="blue-cell"><a
                                        href="{{ route('public.dog_profile', $dog->id) }}">{{ $dog->name ?? "-" }}</a>
                                </td>
                                <td>{{ $dog->breed->name ?? "-" }}</td>
                                <td>{{ $dog->sex ? ($dog->sex === "F" ? "suka":"pes") : "-" }}</td>
                                <td>{{ $dog->breedingStation ? $dog->breedingStation->name : '-' }}</td>
                                @if(Route::is('public.search.dogs.result'))
                                    <td>{{ $dog->sire ? $dog->sire->name : ($dog->sire_name ?? '-') }}</td>
                                    <td>{{ $dog->dam ? $dog->dam->name : ($dog->dam_name ?? '-') }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section></section>
                    {{ $dogs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
