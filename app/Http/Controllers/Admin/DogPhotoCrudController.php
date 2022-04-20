<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DogPhotoRequest;
use App\Models\DogPhoto;
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
 * Class DogPhotoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DogPhotoCrudController extends CrudController
{
    use ListOperation;
//    use CreateOperation;
//    use UpdateOperation;
//    use DeleteOperation;
    use ShowOperation;
    use ReviseOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(DogPhoto::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dog-photo');
        CRUD::setEntityNameStrings('Fotka psov', 'Fotky psov');
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
//    protected function setupCreateOperation()
//    {
//        CRUD::setValidation(DogPhotoRequest::class);
//
//        CRUD::field('id');
//        CRUD::field('photo_id');
//        CRUD::field('dog_id');
//        CRUD::field('created_at');
//        CRUD::field('updated_at');
//        CRUD::field('deleted_at');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
//    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
//    protected function setupUpdateOperation()
//    {
//        $this->setupCreateOperation();
//    }

    protected function columns($isShow = false)
    {
        CRUD::column('id')->label('ID');
        CRUD::column('photo.path')->type('image')->label('Fotka')->height($isShow ? 'auto' : '50px');
        CRUD::column('dog')->label('Pes');
        CRUD::column('created_at')->label('Dátum vytvorenia');
        CRUD::column('updated_at')->label('Dátum úpravy');
    }
}
