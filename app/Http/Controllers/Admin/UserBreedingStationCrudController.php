<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserBreedingStationRequest;
use App\Models\UserBreedingStation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\ReviseOperation\ReviseOperation;

/**
 * Class UserBreedingStationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserBreedingStationCrudController extends CrudController
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
        CRUD::setModel(UserBreedingStation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-breeding-station');
        CRUD::setEntityNameStrings('Majiteľ chovateľských staníc', 'Majitelia chovateľských staníc');
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

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserBreedingStationRequest::class);

        $this->fields();

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

    protected function setupShowOperation()
    {
        $this->columns(true);
    }

    protected function columns($isShow = false)
    {
        CRUD::set('show.setFromDb', false);
        CRUD::column('id')->label('ID');
        CRUD::column('user')->label('Majiteľ');
        CRUD::column('breedingStation')->label('Chovateľská stanica');
        $isShow ? CRUD::column('created_at')->label('Dátum vytvorenia') : CRUD::column('created_at')->remove();
        $isShow ? CRUD::column('updated_at')->label('Dátum úpravy') : CRUD::column('updated_at')->remove();
    }

    protected function fields()
    {
        CRUD::field('user')->label('Majiteľ');
        CRUD::field('breedingStation')->label('Chovateľská stanica');
    }
}
