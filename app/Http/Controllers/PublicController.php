<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Models\BreedingStation;
use App\Models\Dog;
use App\Models\DogPhoto;
use App\Models\Litter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home()
    {
        $dogCount = Dog::where('dddk', TRUE)->count();
        $userCount = User::count();
        return view('home')->with(compact('dogCount', 'userCount'));
    }

    public function owner($id)
    {
        $user = User::findOrFail($id);

        return view('public.owner_profile')->with(compact('user'));
    }

    public function dog($id)
    {
        $dog = Dog::with('photos')->findOrFail($id);
        $tree = json_encode([
            'key_1' => ['trad' => $dog->name ?? "-", 'route' => route('public.dog_profile', $dog->id)],
            'key_2' => ['trad' => $dog->sire->name ?? "-", 'route' => $dog->sire ? route('public.dog_profile', $dog->sire->id) : null],
            'key_3' => ['trad' => $dog->dam->name ?? "-", 'route' => $dog->dam ? route('public.dog_profile', $dog->dam->id) : null],
        ]);

        return view('public.dog_profile')->with(compact('dog', 'tree'));
    }

    public function dogs(Request $request)
    {
        $dogs = Dog::with(['breedingStation', 'breed'])
            ->orderBy('name')
            ->when($request->sortBy, function ($query, $value) use ($request) {
                if (in_array($value, ['breed', 'breedingStation'])) {
                    $query->whereHas($value, function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%");
                    });
                } else {
                    $query->where('name', 'like', "%{$request->search}%");
                }
            })
            ->when($request->startsWith, function ($query, $value) {
                $query->where('name', 'like', "$value%")
                    ->orderBy('name');
            })->paginate(15)
            ->withQueryString();

        $request->flash();
        return view('public.dogs')->with(compact('dogs'));
    }

    public function owners(Request $request)
    {
        $owners = User::with(['breedingStation'])
            ->orderBy('last_name')
            ->when($request->sortBy, function ($query, $value) use ($request) {
                if ($value === 'breedingStation') {
                    $query->whereHas('breedingStation', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%");
                    });
                } else {
                    $query->where($value, 'like', "%{$request->search}%");
                }
            })
            ->when($request->startsWith, function ($query, $value) {
                $query->where('last_name', 'like', "$value%");
            })->paginate(15)
            ->withQueryString();

        $request->flash();
        return view('public.owners')->with(compact('owners'));
    }

    public function litters()
    {
        $litters = Litter::paginate(15);
        return view('public.litters')->with(compact('litters'));
    }

    public function littersCount(Request $request)
    {
        $dogs = Dog::with(['myLitters', 'breed', 'user'])
            ->paginate(15);

        $request->flash();
        return view('public.litters_count')->with(compact('dogs'));
    }

    public function statisticsBreeds(Request $request)
    {
        $dddkBreeds = Breed::withCount(['dogs' => function ($query) {
            $query->where('dddk', true);
        }])->get();

        $nonDddkBreeds = Breed::withCount(['dogs' => function ($query) {
            $query->where('dddk', false);
        }])->get();

        return view('public.statistics.breeds')->with(compact('dddkBreeds', 'nonDddkBreeds'));
    }

    public function statisticsOwners(Request $request)
    {
        $municipalities = User::select('municipality', DB::raw('count(*) as total'))
            ->groupBy('municipality')
            ->get();

        return view('public.statistics.owners')->with(compact('municipalities'));
    }

    public function statisticsStations(Request $request)
    {
        $stations = BreedingStation::when($request->startsWith, function ($query, $value) {
            $query->where('name', 'like', "$value%");
        })->when($request->search, function ($query, $value) {
            $query->where('name', 'like', "%$value%");
        })->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $request->flash();
        return view('public.statistics.stations')->with(compact('stations'));
    }

    public function statisticsDddk(Request $request)
    {
        $hds = Dog::where('dddk', 1)
            ->select(['hd', DB::raw('count(*) as total')])
            ->groupBy('hd')
            ->orderBy('hd')
            ->get();

        $eds = Dog::where('dddk', 1)
            ->select(['ed', DB::raw('count(*) as total')])
            ->groupBy('ed')
            ->orderBy('ed')
            ->get();

        $eics = Dog::where('dddk', 1)
            ->select(['eic', DB::raw('count(*) as total')])
            ->groupBy('eic')
            ->orderBy('eic')
            ->get();

        $sexes = Dog::where('dddk', 1)
            ->select(['sex', DB::raw('count(*) as total')])
            ->groupBy('sex')
            ->orderBy('sex')
            ->get();

        return view('public.statistics.dddk')->with(compact('hds', 'eds', 'eics', 'sexes'));
    }

    public function searchDogs(Request $request)
    {
        $dogs = Dog::when($request->name, function ($query, $value) {
            $query->where('name', 'like', "%$value%");
        })->when($request->station, function ($query, $value) {
            $query->whereHas('breedingStation', function ($query) use ($value) {
                $query->where('name', 'like', "%$value%");
            });
        })->when($request->breed_id, function ($query, $value) {
            $query->where('breed_id', $value);
        })->when($request->sex, function ($query, $value) {
            $query->where('sex', $value);
        })->when($request->HD, function ($query, $value) {
            $query->where('hd', 'like', "%$value%");
        })->when($request->ED, function ($query, $value) {
            $query->where('ed', 'like', "%$value%");
        })->when($request->EIC, function ($query, $value) {
            $query->where('eic', 'like', "%$value%");
        })->when($request->eyes, function ($query, $value) {
            $query->where('eyes', 'like', "%$value%");
        })->when($request->has_image, function ($query) {
            $query->has('photos');
        })->when($request->dddk, function ($query) {
            $query->where('dddk', true);
        })->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('public.dogs')->with(compact('dogs'));
    }

    public function searchOwners(Request $request)
    {
        $owners = User::when($request->last_name, function ($query, $value) {
            $query->where('last_name', 'like', "%$value%");
        })->when($request->station, function ($query, $value) {
            $query->whereHas('breedingStation', function ($query) use ($value) {
                $query->where('name', 'like', "%$value%");
            });
        })->when($request->city, function ($query, $value) {
            $query->where('city', 'like', "%$value%");
        })->when($request->county, function ($query, $value) {
            $query->where('county', 'like', "%$value%");
        })->when($request->municipality, function ($query, $value) {
            $query->where('municipality', 'like', "%$value%");
        })->orderBy('last_name')
            ->paginate(15)
            ->withQueryString();

        return view('public.owners')->with(compact('owners'));
    }

    public function select2OwnersAjax(Request $request)
    {
        $term = $request->search;
        $response = [];
        foreach (User::whereNull('deleted_at')
                     ->where('name', 'like', "%$term%")
                     ->get() as $user) {
            if (\Auth::id() !== $user->id) {
                $response[] = [
                    'id' => $user->id,
                    'text' => $user->name
                ];
            }
        }

        return $response;
    }
}
