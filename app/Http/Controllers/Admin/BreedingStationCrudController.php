<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BreedingStationRequest;
use App\Models\BreedingStation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\ReviseOperation\ReviseOperation;
use Illuminate\Http\Request;

/**
 * Class BreedingStationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class BreedingStationCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    use ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(BreedingStation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/breeding-station');
        CRUD::setEntityNameStrings('Chovateľská stanica', 'Chovateľské stanice');
        CRUD::addButtonFromView('line', 'approve', 'breedingStation.approve');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->columns();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    protected function setupShowOperation()
    {
        $this->columns(true);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BreedingStationRequest::class);

        CRUD::field('name')->label('Názov');
        CRUD::field('description')->label('Popis');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function columns($isShow = false)
    {
        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Názov');
        CRUD::column('user')->label('Majiteľ');
        CRUD::column('description')->label('Popis');
//        CRUD::column('status')->label('Stav');
        !$isShow ?: CRUD::column('dogs')->label('Psi');
        !$isShow ?: CRUD::column('created_at')->label('Dátum vytvorenia');
        !$isShow ?: CRUD::column('updated_at')->label('Dátum úpravy');
    }

    public function approve(Request $request)
    {
        $id = $request->id;
        if (($station = BreedingStation::find($id)) !== null) {
            if ($station->status === 'approved') {
                \Alert::error('Položka už je schválená.')->flash();
            } elseif (\Auth::user()->hasRole('admin')) {
                $station->update(['status' => 'approved']);
                \Alert::success('Položka bola schválená.')->flash();
                return redirect(backpack_url('breeding-station'));
            } else {
                \Alert::error('Nemáte oprávnenie na schvaľovanie.')->flash();
            }
        } else {
            \Alert::error('Položka neexistuje.')->flash();
        }

        return back();
    }
}
