@extends('layouts.area.app')
@php
  /** @var \App\Models\User $user */
    $user = Auth::user();
@endphp

@section('content')
    @include('area.components.WelcomeBar')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('layouts.components.Sidebar')
            </div>
            <div class="col-lg-9">

                <h2 class="text-center text-uppercase">ZMENA ÚDAJOV</h2>
                <hr class="blue-hr hr-m-bottom">

                <form action="{{ route('area.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="first_name" class="form-label">Meno <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                   value="{{ old('first_name') ? old('first_name') : $user->first_name }}" required/>
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <label for="last_name" class="form-label">Priezvisko</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                   value="{{ old('last_name') ? old('last_name') : $user->last_name }}" required/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                   value="{{ old('email') ? old('email') : $user->email }}" required/>
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <label for="nationality_id" class="form-label">Národnosť  <span class="text-danger">*</span></label>
                            <select name="nationality_id" id="nationality_id">
                                <option value=""></option>
                                @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                                    <option value="{{ $country->id }}" @if($country->id == $user->nationality_id) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="street" class="form-label">Ulica</label>
                            <input type="text" class="form-control" name="street" id="street"
                                   value="{{ old('street') ? old('street') : $user->street }}" />
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <label for="city" class="form-label">Mesto</label>
                            <input type="text" class="form-control" name="city" id="city"
                                   value="{{ old('city') ?? $user->city }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label class="form-label" for="zip">PSČ</label>
                            <input type="text" class="form-control" name="zip" id="zip"
                                   value="{{ old('zip') ?? $user->zip }}" />
                        </div>
                        <div class="col-lg-6">
                            <label for="county" class="form-label">Okres</label>
                            <input type="text" class="form-control" name="county" id="county"
                                   value="{{ old('county') ? old('county') : $user->county }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="municipality" class="form-label">Kraj</label>
                            <select name="municipality" id="municipality">
                                <option value=""></option>
                                @foreach(\App\Models\Country::municipalities as $key => $value)
                                    <option value="{{ $value }}" @if($user->municipality == $value) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="phone" class="form-label">Telefón</label>
                            <input type="text" class="form-control" name="phone" id="phone"
                                   value="{{ old('phone') ? old('phone') : $user->phone }}"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="birthday" class="form-label">Dátum narodenia</label>
                            <input type="date" class="form-control" name="birthday" id="birthday"
                                   value="{{ old('birthday') ? old('birthday') : $user->date_of_birth }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6 custom-checkbox">
                            <div class="control-group">
                                <label class="control control-checkbox">
                                    Mám záujem o využitie rodinného členstva
                                    <input type="checkbox" id="is-family-input" @if($user->family_membership_parent_id) checked @endif/>
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" id="is-family-div" @if(!$user->family_membership_parent_id) style="display: none" @endif>
                        <div class="col-lg-6">
                            <label for="family_membership_parent_id" class="form-label">Meno a priezvisko hlavného člena</label>
{{--                            <input type="text" class="form-control" name="family_membership_parent_id" id="family_membership_parent_id"--}}
{{--                                   value="{{ old('family_membership_parent_id') ?? $user->family_membership_parent_id }}" />--}}
                            <select name="family_membership_parent_id" id="family_membership_parent_id"></select>
                        </div>
                    </div>

                    <hr class="blue-hr mt-5 mb-3">

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="other_club_membership" class="form-label">Som člen iného chovateľského klubu (ak áno, napíšte akého, inak nechajte prázdne)</label>
                            <input type="text" class="form-control" name="other_club_membership" id="other_club_membership"
                                   value="{{ old('other_club_membership') ?? $user->other_club_membership }}" />
{{--                            <select name="other_club_membership" id="other_club_membership">--}}
{{--                                <option value="1" {{ $user->other_club_membership != null ? "selected" : "" }}>Áno</option>--}}
{{--                                <option value="0" {{ $user->other_club_membership == null ? "selected" : "" }}>Nie</option>--}}
{{--                            </select>--}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="cp_spz" class="form-label">Som člen OkO – RgO SPZ (ak áno, napíšte číslo preukazu, inak nechajte prázdne)</label>
                            <input type="text" class="form-control" name="cp_spz" id="cp_spz"
                                   value="{{ old('cp_spz') ?? $user->cp_spz }}" />
{{--                            <select name="spz_membership" id="spz_membership">--}}
{{--                                <option value="1">Áno</option>--}}
{{--                                <option value="0">Nie</option>--}}
{{--                            </select>--}}
                        </div>
                    </div>
{{--                    <div class="row mb-3">--}}
{{--                        <div class="col-12">--}}
{{--                            <label for="protected" class="form-label">Mám chránený názov chovateľskej stanice  </label>--}}
{{--                            <input type="text" class="form-control" name="spz_membership" id="spz_membership"--}}
{{--                                   value="{{ old('spz_membership') ?? $user->spz_membership }}" />--}}
{{--                            <select name="protected" id="protected">--}}
{{--                                <option value="1">Áno</option>--}}
{{--                                <option value="0">Nie</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="row mb-3">
                        <div class="col-12 custom-checkbox">
                            <div class="control-group">
                                <label class="control control-checkbox">
                                    Som dôchodca
                                    <input type="checkbox" name="is_senior" id="is_senior" @if($user->is_senior) checked @endif/>
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 custom-checkbox">
                            <div class="control-group">
                                <label class="control control-checkbox">
                                    Som zdravotne ťažko postihnutá osoba
                                    <input type="checkbox" name="is_handicapped" @if($user->is_handicapped) checked @endif/>
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 custom-checkbox">
                            <div class="control-group">
                                <label class="control control-checkbox">
                                    Chcem zverejniť osobné údaje
                                    <input type="checkbox" name="accepted_data_publication" @if($user->accepted_data_publication) checked @endif/>
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>


                <h2 class="text-center text-uppercase mt-5">Zmena hesla</h2>
                <hr class="blue-hr mb-4">
                <p class="text-center hr-m-bottom" style="font-size: 1.3rem">Ak heslo nechcete zmeniť, polia nechajte prázdne</p>
                <form action="{{ route('area.profile.update-password') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label for="actual_password">Aktuálne heslo</label>
                            <input type="password" name="actual_password" id="actual_password">
                        </div>
                        <div class="col-12 mb-4">
                            <label for="password">Nové heslo</label>
                            <input type="password" name="password" id="password">

                        </div>
                        <div class="col-12 mb-4">
                            <label for="password_confirmation">Potvrdenie hesla</label>
                            <input type="password" name="password_confirmation" id="password_confirmation">
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="submit-container">
                                <button type="submit">Uložiť zmeny</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('scripts.user-form-select2-init')
@endpush
