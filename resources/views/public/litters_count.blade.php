@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">Počet párení uchovnených psov</h2>
                    <hr class="blue-hr mb-2">
                </section>
                <section></section>

                <div class="table-responsive whelps-container">

                    <table class="table table-bordered mt-5">
                        <thead>
                        <tr>
                            <th>Pl:</th>
                            <th scope="col">Meno psa:</th>
                            <th scope="col">Majiteľ:</th>
                            <th scope="col">Počet párení:</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dogs as $dog)
                            <tr>
                                <th scope="row">{{ $dog->breed->code ?? '' }}</th>
                                <td class="blue-cell">
                                    <a href="{{ route('public.dog_profile', ['id' => $dog->id]) }}">
                                        {{ $dog->name }}
                                    </a>
                                </td>
                                <td class="blue-cell">
                                    @if($dog->user)
                                        <a href="{{ route('public.owner_profile', ['id' => $dog->user->id]) }}">
                                            {{ $dog->user ? $dog->user->name : '-' }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $dog->myLitters->count() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section></section>
                    <div class="text-center">
                        {{ $dogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
