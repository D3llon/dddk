<section class="register">
    <h3 class="text-center">Žiadosť o členstvo</h3>
    <hr class="blue-hr mb-5">
    <form method="POST" action="{{ route('register') }}" class="register-form">
        @csrf
        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="first_name" class="form-label">Meno  <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" required autocomplete="given-name" autofocus />
            </div>
            <div class="col-lg-6">
                <label for="last_name" class="form-label">Priezvisko  <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="email" class="form-label">E-mail  <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" />
            </div>
            <div class="col-lg-6">
                <label for="nationality_id" class="form-label">Národnosť  <span class="text-danger">*</span></label>
                <select name="nationality_id" id="nationality_id">
                    <option value=""></option>
                    @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                        <option value="{{ $country->id }}" @if(old('nationality_id') == $country->id) selected @endif>{{ $country->name }}</option>
                    @endforeach
                </select>
{{--                <input type="text" class="form-control" name="nationality_id" id="nationality_id" value="{{ old('last_name') }}" required autocomplete="nationality_id" />--}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="street" class="form-label">Ulica</label>
                <input type="text" class="form-control" name="street" id="street" value="{{ old('street') }}" autocomplete="address-level2" />
            </div>
            <div class="col-lg-6">
                <label for="city" class="form-label">Mesto</label>
                <input type="text" class="form-control" name="city" id="city" value="{{ old('city') }}" autocomplete="address-level1" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6">
                <label class="form-label" for="zip">PSČ</label>
                <input type="text" class="form-control" name="zip" id="zip" value="{{ old('zip') }}" />
            </div>
            <div class="col-lg-6">
                <label for="county" class="form-label">Okres</label>
                <input type="text" class="form-control" name="county" id="county" value="{{ old('county') }}" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="municipality" class="form-label">Kraj</label>
                <select name="municipality" id="municipality">
                    <option value=""></option>
                    @foreach(\App\Models\Country::municipalities as $key => $value)
                        <option value="{{ $value }}" @if(old('municipality') == $value) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6">
                <label for="phone" class="form-label">Telefón</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" autocomplete="phone" />
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-lg-6">
                <label for="date_of_birth" class="form-label">Dátum narodenia</label>
                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" autocomplete="bday" />
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6 custom-checkbox">
                <div class="control-group">
                    <label class="control control-checkbox">
                        Mám záujem o využitie rodinného členstva
                        <input type="checkbox" id="is-family-input"/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3" id="is-family-div" style="display: none">
            <div class="col-lg-6">
                <label for="family_membership_parent_id" class="form-label">Meno a priezvisko hlavného člena</label>
{{--                <input type="text" class="form-control" name="family_membership_parent_id" id="family_membership_parent_id" value="{{ old('family_membership_parent_id') }}" autocomplete="family_membership_parent_id" />--}}
                <select name="family_membership_parent_id" id="family_membership_parent_id"></select>
            </div>
        </div>

        <hr class="blue-hr mt-5 mb-3">

{{--        <div class="row mb-3">--}}
{{--            <div class="col-lg-6">--}}
{{--                <label for="exampleInputEmail1" class="form-label">Som držiteľom psa</label>--}}
{{--                <select name="#" id="#" class="form-control">--}}
{{--                    <option value="">1</option>--}}
{{--                    <option value="">2</option>--}}
{{--                    <option value="">3</option>--}}
{{--                    <option value="">4</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                <label for="exampleInputEmail1" class="form-label">Od roku</label>--}}
{{--                <select name="#" id="#" class="form-control">--}}
{{--                    <option value="">2001</option>--}}
{{--                    <option value="">2002</option>--}}
{{--                    <option value="">2003</option>--}}
{{--                    <option value="">2004</option>--}}
{{--                </select>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="row mb-3">
            <div class="col-12">
                <label for="other_club_membership" class="form-label">Som člen iného chovateľského klubu (ak áno, napíšte akého, inak nechajte prázdne)</label>
                <input type="text" class="form-control" name="other_club_membership" id="other_club_membership" value="{{ old('other_club_membership') }}" />
{{--                <select name="other_club_membership" id="other_club_membership">--}}
{{--                    <option value="1">Áno</option>--}}
{{--                    <option value="0">Nie</option>--}}
{{--                </select>--}}
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label for="spz_membership" class="form-label">Som člen OkO – RgO SPZ (ak áno, napíšte číslo preukazu, inak nechajte prázdne)</label>
                <input type="text" class="form-control" name="spz_membership" id="spz_membership" value="{{ old('spz_membership') }}" />
{{--                <select name="spz_membership" id="spz_membership">--}}
{{--                    <option value="1">Áno</option>--}}
{{--                    <option value="0">Nie</option>--}}
{{--                </select>--}}
            </div>
        </div>


{{--        <div class="row mb-3">--}}
{{--            <div class="col-12">--}}
{{--                <label for="exampleInputEmail1" class="form-label">Mám chránený názov chovateľskej stanice</label>--}}
{{--                <input type="text" name="" id="" class="form-control">--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row mb-3">--}}
{{--            <div class="col-lg-6 boxed">--}}
{{--                <div class="d-flex flex-column">--}}
{{--                    <label for="exampleInputEmail1" class="form-label ">Som dôchodca</label>--}}
{{--                    <div>--}}
{{--                        <input required type="radio" name="form_retirement" id="retirement_yes" value="1">--}}
{{--                        <label for="retirement_yes" class="label-answer">Áno</label>--}}
{{--                        <input required type="radio" name="form_retirement" id="retirement_no" value="0">--}}
{{--                        <label for="retirement_no" class="label-answer">Nie</label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-lg-6 boxed">--}}
{{--                <div class="d-flex flex-column">--}}
{{--                    <label for="exampleInputEmail1" class="form-label ">Som ťažko zdravotne postihnutý</label>--}}
{{--                    <div>--}}
{{--                        <input required type="radio" name="form_tzp" id="tzp_yes" value="1">--}}
{{--                        <label for="tzp_yes" class="label-answer">Áno</label>--}}
{{--                        <input required type="radio" name="form_tzp" id="tzp_no" value="0">--}}
{{--                        <label for="tzp_no" class="label-answer">Nie</label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="row mb-3">
            <div class="col-12 custom-checkbox">
                <div class="control-group">
                    <label class="control control-checkbox">
                        Som dôchodca
                        <input type="checkbox" name="is_senior" id="is_senior"/>
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
                        <input type="checkbox" name="is_handicapped"/>
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
                        <input type="checkbox" name="accepted_data_publication"/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
            </div>
        </div>


        <div class="row mb-3 mt-5">
            <div class="col-12 custom-checkbox">
                <div class="control-group">
                    <label class="control control-checkbox">
                        <span class="text-danger">*</span> Vyhlasujem, že sa podrobujem stanovám DDDK, ustanoveniam klubových poriadkov
                        a uzneseniam orgánov klubu. Uvedené údaje sú pravdivé a úplné.
                        <input type="checkbox" name="dddk_statute" required/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 custom-checkbox">
                <div class="control-group">
                    <label class="control control-checkbox">
                        <span class="text-danger">*</span> Odoslaním formulára potvrdzujem, že v zmysle ustanovení
                        nariadenia Európskeho parlamentu a rady (EÚ) 2016/679, z 27. apríla 2016 o ochrane
                        fyzických osôb pri spracúvaní osobných údajov a o voľnom pohybe takýchto údajov (GDPR) a
                        ustanoveniami
                        zákona č. 18/2018 o ochrane osobných
                        údajov a o zmene a doplnení niektorých zákonov, som bol oboznámený so spracúvaním mojich
                        osobných
                        údajov prevádzkovateľom
                        DDDK; so svojimi právami a podmienkami spracúvania osobných údajov prevádzkovateľom.
                        Spracúvanie osobných údajov prevádzkovateľom
                        je podľa predmetu činností vykonávané najmä na právnom základe plnenia zákonnej povinnosti,
                        právnom
                        základe predzmluvných vzťahov a plnenia
                        zmluvy a právnom základe oprávneného záujmu prevádzkovateľa.
                        <input type="checkbox" name="gdpr" required/>
                        <div class="control_indicator"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary text-center">Odoslať prihlášku</button>
        </div>
    </form>
</section>


@push('js')
    @include('scripts.user-form-select2-init')
@endpush
