@extends('layouts.area.app')

@section('content')
    @include('auth.register.RegisterJumbotronContent')
    <div class="container">
        <div class="row">
            <div class="col py-5">
                @include('auth.register.components.Form')
            </div>
        </div>
    </div>
@endsection

