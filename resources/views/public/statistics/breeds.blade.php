@extends('public.stats_layout')

@section('body')
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="w-50" scope="col">Plemeno:</th>
                        <th class="w-50" scope="col">Počet psov uchovnených v DDDK:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dddkBreeds as $breed)

                        <tr>
                            <td>{{ $breed->name }}</td>
                            <td>{{ $breed->dogs_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <section></section>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="w-50" scope="col">Plemeno:</th>
                        <th class="w-50" scope="col">Počet zahraničných psov:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($nonDddkBreeds as $breed)
                        <tr>
                            <td>{{ $breed->name }}</td>
                            <td>{{ $breed->dogs_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-bottom: 5rem"></div>
    </div>
@endsection