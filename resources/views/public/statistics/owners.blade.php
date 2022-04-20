@extends('public.stats_layout')

@section('body')
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="w-50" scope="col">Kraj:</th>
                        <th class="w-50" scope="col">Počet:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($municipalities as $municipality)
                        <tr>
                            <td>{{ $municipality->municipality ?? "-" }}</td>
                            <td>{{ $municipality->total ?? "-" }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-bottom: 5rem"></div>
    </div>
@endsection