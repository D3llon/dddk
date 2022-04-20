<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DogRequest;
use App\Models\Dog;
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
 * Class DogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DogCrudController extends CrudController
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
        CRUD::setModel(Dog::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dog');
        CRUD::setEntityNameStrings('Pes', 'Psi');
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
        $entry = CRUD::getCurrentEntry();
        CRUD::setValidation(DogRequest::class);

        CRUD::field('name')->label('Meno');
        CRUD::field('breed')->label('Plemeno');
        CRUD::field('sex')->type('enum')->label('Pohlavie');
        CRUD::field('dddk')->label('Uchovnený v DDDK');
        CRUD::field('color')->label('Farba');
        CRUD::field('hd')->label('HD');
        CRUD::field('ed')->label('ED');
        CRUD::field('eyes')->label('Oči');
        CRUD::field('title')->label('Nadpis');
        CRUD::field('notes')->label('Poznámky');
        CRUD::field('sire')->label('Otec')->options(function ($query) use ($entry) {
            $query->where('sex', 'M');
            return $entry ? $query->where('id', '!=', $entry->id) : $query;
        });
        CRUD::field('dam')->label('Matka')->options(function ($query) use ($entry) {
            $query->where('sex', 'F');
            return $entry ? $query->where('id', '!=', $entry->id) : $query;
        });
        CRUD::field('breedingStation')->label('Chovateľská stanica')->type('select2');
        CRUD::field('birth_year')->label('Rok narodenia')->type('number');
        CRUD::field('birth_land')->label('Krajina narodenia');
        CRUD::field('litter')->label('ID vrhu');

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
        $this->crud->set('show.setFromDb', false);
        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Meno');
        CRUD::column('breed')->label('Plemeno');
        CRUD::column('sex')->label('Pohlavie');
        CRUD::column('user')->label('Majiteľ');
        CRUD::column('dddk')->label('Uchovnený v DDDK')->type('boolean')->options([
            0 => 'Nie',
            1 => 'Áno'
        ]);
        CRUD::column('color')->label('Farba');
        $isShow ? CRUD::column('hd')->label('HD') : CRUD::column('hd')->label('HD')->remove();
        $isShow ? CRUD::column('ed')->label('ED') : CRUD::column('ed')->label('ED')->remove();
        $isShow ? CRUD::column('eyes')->label('Oči') : CRUD::column('eyes')->label('Oči')->remove();
        $isShow ? CRUD::column('title')->label('Nadpis') : CRUD::column('title')->label('Nadpis')->remove();
        $isShow ? CRUD::column('notes')->label('Poznámky') : CRUD::column('notes')->label('Poznámky')->remove();
        CRUD::column('sire')->label('Otec');
        CRUD::column('dam')->label('Matka');
        CRUD::column('breedingStation')->label('Chovateľská stanica');
        CRUD::column('birth_year')->label('Rok narodenia');
        CRUD::column('birth_land')->label('Krajina narodenia');
        CRUD::column('litter')->label('ID vrhu');
        CRUD::column('created_at')->remove();
        CRUD::column('updated_at')->remove();
        CRUD::column('deleted_at')->remove();
    }
}
