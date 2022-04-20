<?php

namespace App\Http\Controllers\Admin;

use App\Models\Modification;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class CreationsCrudControllerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CreationCrudController extends CrudController
{
    use ListOperation;
//    use CreateOperation;
//    use UpdateOperation;
//    use DeleteOperation;
    use ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Modification::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/creation');
        CRUD::setEntityNameStrings('Nový záznam', 'Nové záznamy');
        $this->crud->addButtonFromView('line', 'approve', 'modifications.approve');
        $this->crud->addButtonFromView('line', 'decline', 'modifications.decline');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('where', 'is_update', false);
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
        CRUD::setFromDb(); // fields

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
        CRUD::set('show.setFromDb', false);

        CRUD::column('modifiable_type')->label('Model');
        CRUD::addColumn([
            'name' => 'modifier',
            'type' => 'closure',
            'label' => 'Modifikoval',
            'function' => function(Modification $modification) {
                return $modification->modifier->name ?? '-';
            }
        ]);
        if ($isShow) {
            CRUD::addColumn([
                'name' => 'modifications',
                'type' => 'json',
                'label' => 'Zmeny'
            ]);
        }
        CRUD::addColumn([
            'name' => 'updated_at',
            'type' => 'datetime',
            'label' => 'Dátum úpravy'
        ]);
    }

    public function approve(Request $request)
    {
        $id = $request->id;
        if (($modification = Modification::find($id)) != null) {
            if (\Auth::user()->approve($modification)) {
                \Alert::success('Položka bola schválená.')->flash();
                return redirect(backpack_url('creation'));
            } else {
                \Alert::error('Nemáte oprávnenie na schvaľovanie.')->flash();
            }
        } else {
            \Alert::error('Takáto modifikácia neexistuje.')->flash();
        }

        return back();
    }

    public function decline(Request $request)
    {
        $id = $request->id;
        if (($modification = Modification::find($id)) != null) {
            if (\Auth::user()->disapprove($modification)) {
                \Alert::success('Položka bola zamietnutá.')->flash();
            } else {
                \Alert::error('Nemáte oprávnenie na schvaľovanie.')->flash();
            }
        } else {
            \Alert::error('Takáto modifikácia neexistuje.')->flash();
        }

        return back();
    }
}
