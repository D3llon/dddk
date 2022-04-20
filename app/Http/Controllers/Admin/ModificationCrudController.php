<?php

namespace App\Http\Controllers\Admin;

use App\Models\Modification;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class ModificationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ModificationCrudController extends CrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix') . '/modification');
        CRUD::setEntityNameStrings('Modifikácia', 'Modifikácie');
        $this->crud->addButtonFromView('line', 'approve', 'modifications.approve');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('where', 'is_update', true);
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
//    protected function setupCreateOperation()
//    {
//        CRUD::setValidation(ModificationRequest::class);
//
//        CRUD::field('id');
//        CRUD::field('modifiable_id');
//        CRUD::field('modifiable_type');
//        CRUD::field('modifier_id');
//        CRUD::field('modifier_type');
//        CRUD::field('active');
//        CRUD::field('is_update');
//        CRUD::field('approvers_required');
//        CRUD::field('disapprovers_required');
//        CRUD::field('md5');
//        CRUD::field('modifications');
//        CRUD::field('created_at');
//        CRUD::field('updated_at');
//        CRUD::field('deleted_at');
//
//        /**
//         * Fields can be defined using the fluent syntax or array syntax:
//         * - CRUD::field('price')->type('number');
//         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
//         */
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

    protected function setupShowOperation()
    {
        $this->columns(true);
    }

    protected function columns($isShow = false)
    {
        CRUD::column('id');
        CRUD::addColumn([
            'name' => 'modified',
            'type' => 'closure',
            'label' => 'Modifikovany objekt',
            'function' => function (Modification $modification) {
                return $modification->modifiable->name ?? '-';
            }
        ]);
        CRUD::column('modifiable_type');
        CRUD::addColumn([
            'name' => 'modifier',
            'type' => 'closure',
            'label' => 'Modifikoval',
            'function' => function (Modification $modification) {
                return $modification->modifier->name ?? '-';
            }
        ]);
        CRUD::column('modifier_type');
        $isShow
            ? CRUD::column('modifications')->label('Modifikácie')->type('json')
            : CRUD::column('modifications')->remove();
        CRUD::column('created_at');
        CRUD::column('updated_at');
        $isShow
            ? CRUD::column('deleted_at')
            : CRUD::column('deleted_at')->remove();
    }

    public function approve(Request $request)
    {
        $id = $request->id;
        if (($modification = Modification::find($id)) != null) {
            if (\Auth::user()->approve($modification)) {
                \Alert::success('Položka bola schválená.')->flash();
                return redirect(backpack_url('modification'));
            } else {
                \Alert::error('Nemáte oprávnenie na schvaľovanie.')->flash();
            }
        } else {
            \Alert::error('Takáto modifikácia neexistuje.')->flash();
        }

        return back();
    }
}
