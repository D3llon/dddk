<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use App\Http\Controllers\Admin\BreedingStationCrudController;
use App\Http\Controllers\Admin\CreationCrudController;
use App\Http\Controllers\Admin\LitterCrudController;
use App\Http\Controllers\Auth\LoginController;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
//    Auth::routes();
    Route::get('logout', [LoginController::class, 'logout']);
    Route::get('login', function () {
        return redirect(route('login'));
    })->withoutMiddleware('admin');
    Route::crud('breed', 'BreedCrudController');
    Route::crud('breeding-station', 'BreedingStationCrudController');
    Route::get('breeding-station/{id}/approve', [BreedingStationCrudController::class, 'approve'])->name('admin.breeding-station.approve');
    Route::crud('dog', 'DogCrudController');
    Route::crud('dog-photo', 'DogPhotoCrudController');
    Route::crud('event', 'EventCrudController');
    Route::crud('event-registration', 'EventRegistrationCrudController');
    Route::crud('event-type', 'EventTypeCrudController');
    Route::crud('litter', 'LitterCrudController');
//    Route::crud('personal-access-token', 'PersonalAccessTokenCrudController');
    Route::crud('photo', 'PhotoCrudController');
//    Route::crud('user-breed', 'UserBreedCrudController');
//    Route::crud('user-breeding-station', 'UserBreedingStationCrudController');
//    Route::crud('user-dog', 'UserDogCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::get('select2-sire-owner', [LitterCrudController::class, 'getSireOwner'])->name('admin.get-select2-sire-owner');
    Route::get('select2-dam-owner', [LitterCrudController::class, 'getDamOwner'])->name('admin.get-select2-dam-owner');
    Route::crud('creation', 'CreationCrudController');
    Route::get('creation/{id}/approve', [CreationCrudController::class, 'approve'])->name('admin.creation.approve');
    Route::get('creation/{id}/decline', [CreationCrudController::class, 'decline'])->name('admin.creation.decline');
    Route::crud('modification', 'ModificationCrudController');
}); // this should be the absolute last line of this file
