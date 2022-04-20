@extends('layouts.area.app')

@php
    /** @var \App\Models\Event $event */
    /** @var \App\Models\User $user */
@endphp
@section('content')
    @include('area.components.WelcomeBar')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('layouts.components.Sidebar')
            </div>
            <div class="col-lg-9">
                <h2 class="text-center text-uppercase">Prihlásenie na udalosť - {{ $event->name }}</h2>
                <hr class="blue-hr">

                <form action="{{ route('area.event.signup', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="name" class="form-label">Meno majiteľa <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" value="{{ $user->name }}" disabled />
                        </div>
                        <div class="col-lg-6">
                            <label for="dog_id" class="form-label">Pes <span class="text-danger">*</span></label>
                            <select name="dog_id" id="dog_id" required>
                                <option value=""></option>
                                @foreach($user->dogs as $dog)
                                    <option value="{{ $dog->id }}">{{ $dog->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <div class="d-flex justify-content-center my-5">
                                <a target="_blank" href="{{ asset($event->registration) }}">
                                    <button type="button">Tu si stiahnite prihlášku, vyplňte ju a prosím nahrajte vo formáte PDF.</button>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="registration" class="form-label">Vyplnená prihláška <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="registration" id="registration"
                                   accept="application/pdf" required />
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-center my-5">
                                <button type="submit">Odoslať žiadosť o registráciu</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection