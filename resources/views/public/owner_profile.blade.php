@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">Profil majiteľa:</h2>
                    <hr class="blue-hr mb-5">
                </section>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Meno a priezvisko:</th>
                                    <th>{{ $user->name ?? "-" }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Ulica:</td>
                                    <td>{{ $user->street ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>PSČ:</td>
                                    <td>{{ $user->zip ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Obec:</td>
                                    <td>{{ $user->city ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Okres:</td>
                                    <td>{{ $user->county ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Kraj:</td>
                                    <td>{{ $user->municipality ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Chovateľská stanica:</td>
                                    <td>
                                        {{ $user->breedingStation ? $user->breedingStation->name:"-" }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $user->email ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Telefón:</td>
                                    <td>{{ $user->phone ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Web:</td>
                                    <td>
                                        @if($user->web)
                                            <a href="{{ $user->web }}">{{ $user->web }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Majiteľ jedincov:</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->dogs as $dog)
                                    <tr>
                                        <td><a href="{{ route('public.dog_profile', $dog->id) }}" class="blue-cell">{{ $dog->name }}</a> / {{ $dog->breed->name }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="margin-bottom: 5rem"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
