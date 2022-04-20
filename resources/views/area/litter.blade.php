@extends('layouts.area.app')

@section('content')
    @include('area.components.WelcomeBar')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('layouts.components.Sidebar')
            </div>
            <div class="col-lg-9">

                <h2 class="text-center text-uppercase">Vrhy</h2>
                <hr class="blue-hr">

                <div class="table-responsive whelps-container   ">

                    <table class="table table-bordered mt-5">
                        <thead>
                        <tr>
                            <th style="width: 3rem" class="text-center">Pl:</th>
                            <th scope="col">Jedince:</th>
                            <th scope="col">Majitelia:</th>
                            <th scope="col">Deň párenia:</th>
                            <th scope="col">Deň vrhu:</th>
                            <th scope="col">Narodené<br>psy / suky:</th>
                            <th scope="col">Ponechané<br>psy / suky:</th>
                            <th scope="col">Farba<br>psy / suky:</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($litters as $litter)
                            <tr>
                                <th scope="row">
                                    @foreach(explode(" ", $litter->breed->name) as $word)
                                        {{$word[0]}}
                                    @endforeach
                                </th>
                                <td>
                                    @if($litter->dam)
                                        S: <a href="{{ route('public.dog_profile', $litter->dam->id) }}"
                                            class="span-blue">{{ $litter->dam->name }}</a>
                                    @else
                                        S: <span
                                            class="span-blue">{{ $litter->foreign_dam_name }}</span>
                                    @endif
                                        <br>
                                    @if($litter->sire)
                                        P: <a href="{{ route('public.dog_profile', $litter->sire->id) }}"
                                              class="span-blue">{{ $litter->sire->name }}</a>
                                    @else
                                        P: <span
                                            class="span-blue">{{ $litter->foreign_sire_name }}</span>
                                    @endif

                                </td>
                                <td>
                                    S: <a class="span-blue" href="{{$litter->damOwner ? route('public.owner_profile', $litter->damOwner->id) : '#'}}">{{ $litter->damOwner ? $litter->damOwner->name : '-' }}</a>
                                    <br>
                                    P: <a class="span-blue" href="{{$litter->sireOwner ? route('public.owner_profile', $litter->sireOwner->id) : '#'}}">{{ $litter->sireOwner ? $litter->sireOwner->name : '-' }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($litter->mating_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($litter->litter_date)->format('Y-m-d') }}</td>
                                <td>{{ $litter->pups_male . ' / ' . $litter->pups_female }}</td>
                                <td>{{ $litter->kept_male . ' / ' . $litter->kept_female }}</td>
                                <td>{{ $litter->kept_male_colors . ' / ' . $litter->kept_female_colors }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
