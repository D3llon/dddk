@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <section class="text-center">
                    <h2 class="text-center">Prehľad vrhov</h2>
                    <hr class="blue-hr mb-2">
                    <a href="{{ route('public.litters-count') }}"><p class="blue-cell">Počet párení uchovnených psov</p></a>
                </section>
                <section></section>

                <div class="table-responsive whelps-container">

                    <table class="table table-bordered mt-5">
                        <thead>
                        <tr>
                            <th>Pl:</th>
                            <th scope="col">Jedince:</th>
                            <th scope="col">Majitelia:</th>
                            <th scope="col">Deň párenia:</th>
                            <th scope="col">Deň vrhu:</th>
                            <th scope="col" colspan="2">Narodené<br>psy / suky:</th>
                            <th scope="col" colspan="2">Ponechané<br>psy / suky:</th>
                            <th scope="col">Farba<br>psy / suky:</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($litters as $litter)
                            <tr>
                                <th scope="row">LR</th>
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
                                    S: <a class="span-blue"
                                          href="{{$litter->damOwner ? route('public.owner_profile', $litter->damOwner->id) : '#'}}">{{ $litter->damOwner ? $litter->damOwner->name : '-' }}</a>
                                    <br>
                                    P: <a class="span-blue"
                                          href="{{$litter->sireOwner ? route('public.owner_profile', $litter->sireOwner->id) : '#'}}">{{ $litter->sireOwner ? $litter->sireOwner->name : '-' }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($litter->mating_date)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($litter->litter_date)->format('Y-m-d') }}</td>
                                <td>{{$litter->pups_male}}</td>
                                <td>{{ $litter->pups_female }}</td>
                                <td>{{$litter->kept_male}}</td>
                                <td>{{$litter->kept_female}}</td>
                                <td>{{ $litter->kept_male_colors ?? "-" . ' / ' . $litter->kept_female_colors ?? "-" }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section></section>
                    <div class="text-center">
                        {{ $litters->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
