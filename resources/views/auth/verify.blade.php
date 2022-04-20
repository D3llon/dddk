@extends('layouts.area.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Overte svoju emailovú adresu</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Nový odkaz na overenie bol odoslaný na Vašu emailovú adresu.
                        </div>
                    @endif
                    Než budete pokračovať, skontrolujte prosím či ste obdržali email s odkazom na overenie.
{{--                    {{ __('Before proceeding, please check your email for a verification link.') }}--}}
                    Pokiaľ ste taký email nedostali,
{{--                    {{ __('If you did not receive the email') }},--}}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">kliknite sem pre vyžiadanie nového</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
