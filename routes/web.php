<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\DogController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/owners', [PublicController::class, 'owners'])->name('public.owners');

Route::get('/dogs', [PublicController::class, 'dogs'])->name('public.dogs');

Route::get('/owners/{id}', [PublicController::class, 'owner'])->name('public.owner_profile');

Route::get('/dog/{id}', [PublicController::class, 'dog'])->name('public.dog_profile');

Route::get('/search/owner', function () {
    return view('public.owner_search');
})->name('public.search.owner');
Route::get('/search/owners', [PublicController::class, 'searchOwners'])->name('public.search.owners.result');

Route::get('/search/dog', function () {
    return view('public.dog_search');
})->name('public.search.dog');
Route::get('/search/dogs', [PublicController::class, 'searchDogs'])->name('public.search.dogs.result');

Route::get('/litters', [PublicController::class, 'litters'])->name('public.litters');
Route::get('/litters-count', [PublicController::class, 'littersCount'])->name('public.litters-count');

Route::get('/statistics', [PublicController::class, 'statistics'])->name('public.statistics');
Route::group([
    'prefix' => 'statistics'
], function() {
    Route::get('/',  function () {
        return redirect(\route('public.statistics-breeds'));
    })->name('public.statistics');
    Route::get('breeds', [PublicController::class, 'statisticsBreeds'])->name('public.statistics-breeds');
    Route::get('owners', [PublicController::class, 'statisticsOwners'])->name('public.statistics-owners');
    Route::get('stations', [PublicController::class, 'statisticsStations'])->name('public.statistics-stations');
    Route::get('dddk', [PublicController::class, 'statisticsDddk'])->name('public.statistics-dddk');
});

Route::get('select2-owner-search', [PublicController::class, 'select2OwnersAjax'])->name('select2-owners-ajax');

Route::group([
    'middleware' => 'auth:web',
    'prefix' => 'area'
], function () {
    Route::get('/', function () {
        return redirect(\route('area.dog.index'));
    })->name('area.index');

    Route::group([
        'prefix' => 'dog'
    ], function () {
        Route::get('/', [DogController::class, 'index'])->name('area.dog.index');
        Route::match(['GET', 'POST'],'add', [DogController::class, 'add'])->name('area.dog.add');
        Route::match(['GET', 'POST'],'{id}/edit', [DogController::class, 'edit'])->name('area.dog.edit');
    });

    Route::group([
        'prefix' => 'event'
    ], function () {
        Route::get('/', [AreaController::class, 'events'])->name('area.event.index');
        Route::get('{id}/sign', [AreaController::class, 'eventSignForm'])->name('area.event.sign-form');
        Route::post('{id}/sign', [AreaController::class, 'eventSignup'])->name('area.event.signup');
    });

    Route::get('results', [AreaController::class, 'results'])->name('area.results');

    Route::group([
        'prefix' => 'station'
    ], function () {
        Route::get('/', [AreaController::class, 'station'])->name('area.station.index');
        Route::post('update', [AreaController::class, 'updateStation'])->name('area.station.update');
    });

    Route::get('litters', [AreaController::class, 'litters'])->name('area.litters');

    Route::group([
        'prefix' => 'profile',
    ], function () {
        Route::get('/', [AreaController::class, 'profile'])->name('area.profile.index');
        Route::post('update', [AreaController::class, 'updateProfile'])->name('area.profile.update');
        Route::post('password-update', [AreaController::class, 'updatePassword'])->name('area.profile.update-password');
    });
});
