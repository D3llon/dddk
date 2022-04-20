@extends('area.layout')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">Moji psi</div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Meno</th>
                            <th scope="col">Plemeno</th>
                            <th scope="col">Pohlavie</th>
                            <th scope="col">Farba</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dogs as $dog)
                            @php
                                /** @var \App\Models\Dog $dog */
                            @endphp
                            <tr>
                                <td>
                                    @if(($photo = $dog->photos()->where('primary', true)->first()) !== null)
                                        <img src="/{{ $photo->path_thumb }}" alt="">
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ $dog->name }}</td>
                                <td>{{ $dog->breed->name }}</td>
                                <td>{{ $dog->sex === 'M' ? 'pes' : 'suka' }}</td>
                                <td>{{ $dog->color }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('area.dog.add') }}" class="btn btn-primary">Pridať psa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection