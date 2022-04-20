@extends('public.stats_layout')

@section('body')
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="w-50" scope="col">Pohlavie psov:</th>
                        <th class="w-50" scope="col">Počet psov:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sexes as $sex)
                        <tr>
                            @if ($sex->sex === "F")
                                <td>suka</td>
                            @elseif($sex->sex === "M")
                                <td>pes</td>
                            @else
                                <td>nezadaných</td>
                            @endif
                            <td>{{ $sex->total }}</td>
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
                        <th class="w-50" scope="col">Vyšetrenie HD:</th>
                        <th class="w-50" scope="col">Počet psov:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($hds as $hd)
                        <tr>
                            <td>{{ $hd->hd ?? "nezadaných" }}</td>
                            <td>{{ $hd->total }}</td>
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
                        <th class="w-50" scope="col">Vyšetrenie ED:</th>
                        <th class="w-50" scope="col">Počet psov:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($eds as $ed)
                        <tr>
                            <td>{{ $ed->ed ?? "nezadaných" }}</td>
                            <td>{{ $ed->total }}</td>
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
                        <th class="w-50" scope="col">Vyšetrenie EIC:</th>
                        <th class="w-50" scope="col">Počet psov:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($eics as $eic)
                        <tr>
                            <td>{{ $eic->eic ?? "nezadaných" }}</td>
                            <td>{{ $eic->total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div style="margin-bottom: 5rem"></div>
    </div>
@endsection