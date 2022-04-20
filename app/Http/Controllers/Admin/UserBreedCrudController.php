<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserBreedRequest;
use App\Models\UserBreed;
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
 * Class UserBreedCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class UserBreedCrudController extends CrudController
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
        CRUD::setModel(UserBreed::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-breed');
        CRUD::setEntityNameStrings('Majiteľ plemien', 'Majitelia plemien');
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
        CRUD::setValidation(UserBreedRequest::class);

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

    protected function columns($isShow = false)
    {
        CRUD::column('id')->label('ID');
        CRUD::column('user')->label('Majiteľ');
        CRUD::column('breed')->label('Plemeno');
        $isShow ? CRUD::column('created_at')->label('Dátum vytvorenia') : CRUD::column('created_at')->remove();
        $isShow ? CRUD::column('updated_at')->label('Dátum úpravy') : CRUD::column('updated_at')->remove();
//        CRUD::column('deleted_at');
    }

    protected function fields()
    {
        CRUD::field('user')->label('Majiteľ');
        CRUD::field('breed')->label('Plemeno');
    }
}
