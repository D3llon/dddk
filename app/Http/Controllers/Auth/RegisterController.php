<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/area';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'                  => ['required', 'string', 'max:255'],
            'last_name'                   => ['required', 'string', 'max:255'],
            'email'                       => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'date_of_birth'               => ['sometimes', 'date', 'nullable'],
            'nationality_id'              => ['required', 'exists:countries,id'],
            'street'                      => 'sometimes',
            'city'                        => 'sometimes',
            'county'                      => 'sometimes',
            'municipality'                => 'sometimes',
            'phone'                       => 'sometimes',
            'family_membership_parent_id' => ['sometimes', 'exists:users,id'],
            'cp_spz'                      => 'sometimes',
            'other_club_membership'       => 'sometimes',
            'is_senior'                   => 'accepted',
            'is_handicapped'              => 'accepted',
            'accepted_data_publication'   => 'sometimes',
            'dddk_statute'                 => ['required', 'accepted'],
            'gdpr'                        => ['required', 'accepted']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name'                  => $data['first_name'],
            'last_name'                   => $data['last_name'],
            'email'                       => $data['email'],
            'password'                    => Hash::make(\Str::random()),
            'date_of_birth'               => $data['date_of_birth'] ?? null,
            'nationality_id'              => $data['nationality_id'],
            'street'                      => $data['street'] ?? null,
            'city'                        => $data['city'] ?? null,
            'zip'                         => $data['zip'] ?? null,
            'county'                      => $data['county'] ?? null,
            'municipality'                => $data['municipality'] ?? null,
            'phone'                       => $data['phone'] ?? null,
            'family_membership_parent_id' => $data['family_membership_parent_id'] ?? null,
            'other_club_membership'       => $data['other_club_membership'] ?? null,
            'accepted_data_publication'   => isset($data['accepted_data_publication']),
            'spz_membership'              => $data['spz_membership'] ?? null,
            'is_senior'                   => isset($data['is_senior']),
            'is_handicapped'              => isset($data['is_handicapped']),
        ]);
    }

    public function registered(Request $request, $user)
    {
        return redirect(route('login'))->with('success', 'Vaša registrácia bola úspešne zaevidovaná. Po jej schválení Vás budeme kontaktovať na Vašej emailovej adrese.');
    }
}
