@extends('layouts.public.app')

@section('content')
    @include('public.Jumbotron.StatisticsJumbotronContent')

    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <section class="text-center">
                    <h2 class="text-center">Profil psa:</h2>
                    <hr class="blue-hr mb-5">
                </section>

                <div class="row mb-5">
                    @if($dog->photos->count() > 0)
                        <div class="col-lg-3">
                            <div class="d-flex flex-column gap-3">
                                @foreach($dog->photos as $photo)
                                    <img
                                            src="/{{ $photo->path }}"
                                            alt="Fotka psa {{ $dog->name }}">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="col-lg-6">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Meno:</th>
                                    <th scope="col">{{ $dog->name ?? "-" }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Plemeno:</td>
                                    <td>{{ $dog->breed->name ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Pohlavie:</td>
                                    <td>{{ $dog->sex ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Rok narodenia:</td>
                                    <td>{{ $dog->birth_year ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Úhyn:</td>
                                    <td>{{ $dog->deathdate ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Farba:</td>
                                    <td>{{ $dog->color ?? "-" }} </td>
                                </tr>
                                <tr>
                                    <td>Majiteľ:</td>
                                    <td class="blue-cell">
                                        @if($dog->user)
                                            <a href="{{ route('public.owner_profile', ['id' => $dog->user->id]) }}">
                                                {{ $dog->user->name ?? "-" }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Spolumajiteľ:</td>
                                    <td>{{ $dog->coowner ?? "-" }} </td>
                                </tr>
                                <tr>
                                    <td>Chovateľská stanica:</td>
                                    <td>{{ $dog->breedingStation?->name ?? "-" }} </td>
                                </tr>
                                <tr>
                                    <td>Otec:</td>
                                    @if($dog->sire)
                                        <td class="blue-cell">
                                            <a href="{{ route('public.dog_profile', ['id' => $dog->sire->id]) }}">
                                                {{ $dog->sire->name }}
                                            </a>
                                        </td>
                                    @else
                                        <td>{{ $dog->sire_name ?? '-' }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Matka:</td>
                                    @if($dog->dam)
                                        <td class="blue-cell">
                                            <a href="{{ route('public.dog_profile', ['id' => $dog->dam->id]) }}">
                                                {{ $dog->dam->name }}
                                            </a>
                                        </td>
                                    @else
                                        <td>{{ $dog->dam_name ?? '-' }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Uchovnený v DDDK:</td>
                                    <td>{{ $dog->dddk ? "Áno" : "Nie" }}</td>
                                </tr>
                                <tr>
                                    <td>HD:</td>
                                    <td class="blue-cell">{{ $dog->hd ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>ED:</td>
                                    <td class="blue-cell">{{ $dog->ed ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Oči:</td>
                                    <td>{{ $dog->eyes ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>EIC:</td>
                                    <td>{{ $dog->eic ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Výstavy:</td>
                                    <td class="red-cell">{{ $dog->shows ?? "-" }}</td>
                                </tr>
                                <tr>
                                    <td>Skúšky:</td>
                                    <td class="aqua-cell">{{ $dog->exams ?? "-" }}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>


                    <div class="@if($dog->photos->count() > 0) col-lg-3 @else col-lg-6 @endif">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Uchovnení súrodenci:</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dog->getSiblings() as $sibling)
                                    <tr>
                                        <td class="blue-cell">
                                            <a href="{{ route('public.dog_profile', ['id' => $sibling->id]) }}">
                                                {{ $sibling->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Uchovnení potomkovia:</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dog->puppies as $puppy)
                                    <tr>
                                        <td class="blue-cell">
                                            <a href="{{ route('public.dog_profile', ['id' => $puppy->id]) }}">
                                                {{ $puppy->name }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <section class="text-center">
                    <h2 class="text-center">Rodokmeň:</h2>
                    <hr class="blue-hr mb-5">
                    <div id="my_tree"></div>
                </section>

            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/familytree.css') }}">
@endpush

@push('js')
    <script src="{{ asset('js/familytree.js') }}"></script>
    <script>
        const tree = {
            key_1: {
                key_2: '',
                key_3: '',
            },
        };

        //The parameters of your tree
        const params = {!! $tree !!};
        const route = "{{ route('public.dog_profile', "") }}"

        //The function which will build the tree
        treeMaker(tree, {
            id: 'my_tree', card_click: function (element) {
                // window.location.replace(`${route}/${}`);
                console.log(element)
                console.log(params)
                let route = null;
                switch (element.id) {
                    case "card_key_1":
                        route = params.key_1.route
                        break;
                    case "card_key_2":
                        route = params.key_2.route
                        break;
                    case "card_key_3":
                        route = params.key_3.route
                        break;
                    default:
                        break;
                }
                if (route) {
                    window.location.replace(
                        route
                    )
                }

            },
            treeParams: params,
            'link_width': '2px',
            'link_color': '#eeeeee',
        });
    </script>
@endpush
