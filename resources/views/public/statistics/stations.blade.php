@extends('public.stats_layout')

@section('body')
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="alphabet-container">
                @foreach(\App\Models\Country::alphabet as $key => $letter)
                    <button>
                        <a href="{{ route('public.statistics-stations', ['startsWith' => $letter]) }}" style="color: inherit !important;">
                            {{ $letter }}
                        </a>
                    </button>
                @endforeach
            </div>
            <form action="{{ route('public.statistics-stations') }}">
                <div class="d-flex justify-content-end align-items-center my-3">
                    <div class="whelps-search">
                        Vyhľadaj: <input id="search-input" type="text" name="search" value="{{ old('search') ?? '' }}" />
                    </div>
                </div>
            </form>

            <div class="table-responsive my-5">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="w-50" scope="col">Chovateľská stanica:</th>
                        <th class="w-50" scope="col">Plemeno:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stations as $station)
                        <tr>
                            <td>
                                <a class="blue-cell" href="{{ route('public.search.owners.result', ['station' => $station->name]) }}">
                                    {{ $station->name }}
                                </a>
                            </td>
                            <td>
                                @foreach(\App\Models\Breed::whereIn('id', $station->dogs()->select('breed_id'))->get() as $breed)
                                    {{ $breed->code }} {{ $loop->last ? "":"," }}
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <section></section>
                {{ $stations->links() }}
            </div>
        </div>
        <div style="margin-bottom: 5rem"></div>
    </div>
@endsection