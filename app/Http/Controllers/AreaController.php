<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberUpdateRequest;
use App\Models\BreedingStation;
use App\Models\Document;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Litter;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class AreaController extends Controller
{
    public function profile()
    {
        $user = \Auth::user();
        return view('area.profile')->with(compact('user'));
    }

    public function dogs(Request $request)
    {
        $user = \Auth::user();
        $dogs = $user->dogs;
        return view('area.dogs')->with(compact('dogs'));
    }

    public function updateProfile(Request $request)
    {
        if (($user = \Auth::user()) !== null) {
            $validator = \Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'date_of_birth' => ['sometimes', 'date', 'nullable'],
                'nationality_id' => ['required', 'exists:countries,id'],
                'street' => 'sometimes',
                'city' => 'sometimes',
                'county' => 'sometimes',
                'municipality' => 'sometimes',
                'phone' => 'sometimes',
                'family_membership_parent_id' => ['sometimes', 'exists:users,id'],
                'other_club_membership' => 'sometimes',
                'spz_membership' => 'sometimes',
                'is_senior' => 'accepted',
                'is_handicapped' => 'accepted',
            ]);

            $data = $validator->validated();
            $data['is_senior'] = isset($data['is_senior']);
            $data['is_handicapped'] = isset($data['is_handicapped']);
            $user->update($data);

            return back()->with('success', 'Vaše údaje boli odoslané na spracovanie. O ich schválení Vás budeme informovať.');
        }

        return redirect(route('login'));
    }

    public function updatePassword(Request $request)
    {
        $user = \Auth::user();
        $validator = \Validator::make($request->all(), [
            'actual_password' => [
                'required',
                function($attr, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->getAuthPassword())) {
                        $fail('Vaše aktuálne heslo sa nezhoduje.');
                    }
                }
            ],
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $validator->validated();
        $user->update([
            'password' => \Hash::make($data['password'])
        ]);

        return back()->with('success', 'Vaše heslo bolo úspešne zmenené.');
    }

    public function results()
    {
        return view('area.results');
    }

    public function station()
    {
        $user = auth()->user();
        $station = $user->breedingStation;
//        dd($station, $user);
        return view('area.station', [
            'user'    => $user,
            'station' => $station
        ]);
    }

    public function updateStation(Request $request)
    {
        if (($user = \Auth::user()) !== null) {
            $validator = \Validator::make($request->all(), [
                'name'        => ['required', 'string', 'max:255'],
                'description' => ['sometimes', 'string', 'nullable'],
                'documents'   => ['sometimes', 'array']
            ]);

            if ($validator->fails()) {
                return back()->withInput()->withErrors($validator);
            }

            $data = $validator->validated();
            $data['user_id'] = $user->id;

            $station = BreedingStation::updateOrCreate(['user_id' => $user->id], $data);

            if (isset($data['documents'])) {
                /** @var UploadedFile $document */
                foreach ($data['documents'] as $document) {
                    $documentName = $document->getClientOriginalName();
                    \Storage::disk('public')->put('documents/' . $documentName, $document->getContent());
                    Document::firstOrCreate([
                        'type'                => 'station',
                        'breeding_station_id' => $station->id
                    ], [
                        'name'                => $documentName,
                        'path'                => 'storage/documents/' . $documentName
                    ]);
                }
            }

            return back()->with('success', 'Vaša požiadavka o úpravu chovateľskej stanice bola zaznamenaná.');
        }

        return back()->with('error', 'Nastala chyba, kontaktujte prosím administrátora.');
    }

    public function litters()
    {
        $user = \Auth::user();
//        $myDogsIds = $user->dogs()->select('id');
        $litters = Litter::where('dam_owner_id', $user->id)->orWhere('sire_owner_id', $user->id)->get();
        $litters = [];
        return view('area.litter', [
            'user'    => $user,
            'litters' => $litters
        ]);
    }

    public function events()
    {
        $user = \Auth::user();
        $events = Event::where('date_from', '>=', Carbon::now())->get();
        $pastEvents = Event::where('date_to', '<', Carbon::now())->get();
        return view('area.event.index', [
            'user'       => $user,
            'events'     => $events,
            'pastEvents' => $pastEvents
        ]);
    }

    public function eventSignForm($id)
    {
        $user = \Auth::user();
        if (($event = Event::find($id)) !== null) {
            if ($event->date_to < Carbon::now()->endOfDay()) {
                return redirect(route('area.event.index'))->with('error', 'Nemôžete sa registrovať na ukončenú udalosť!');
            }

            return view('area.event.sign', [
                'event' => $event,
                'user'  => $user
            ]);
        }

        return redirect(route('area.event.index'))->with('error', 'Zadaná udalosť neexistuje.');
    }

    public function eventSignup($id, Request $request)
    {
        if (($event = Event::find($id)) !== null) {
            $validator = \Validator::make($request->all(), [
                'dog_id' => ['required', 'exists:dogs,id'],
                'registration' => ['required', 'file', 'mimes:pdf']
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator);
            }

            $data = $validator->validated();
            $data['user_id'] = \Auth::id();
            $data['event_id'] = $event->id;

            $eventRegistration = EventRegistration::firstOrCreate([
                'event_id' => $event->id,
                'user_id' => \Auth::id()
            ], $data);

            /** @var UploadedFile $document */
            $document = $data['registration'];
            $documentName = $document->getClientOriginalName();
            \Storage::disk('public')->put('documents/events/' . $event->id . '/registrations/' . $documentName, $document->getContent());
            Document::firstOrCreate([
                'type' => Document::TYPE_EVENT_REGISTRATION,
                'event_registration_id' => $eventRegistration->id
            ], [
                'name' => $documentName,
                'path' => 'storage/documents/events/' . $event->id . '/registrations/' . $documentName
            ]);

            return back()->with('success', 'Vaša žiadosť o registráciu bola úspšne odoslaná.');
        }

        return back()->with('error', 'Táto udalosť neexistuje!');
    }
}
