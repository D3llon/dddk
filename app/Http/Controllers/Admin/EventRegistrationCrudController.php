<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventRegistrationRequest;
use App\Models\Document;
use App\Models\EventRegistration;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\ReviseOperation\ReviseOperation;
use Carbon\Carbon;

/**
 * Class EventRegistrationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EventRegistrationCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
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
        CRUD::setModel(EventRegistration::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/event-registration');
        CRUD::setEntityNameStrings('Registrácia na udalosť', 'Registrácie na udalosti');
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
        CRUD::setValidation(EventRegistrationRequest::class);

        CRUD::field('user')->label('Používateľ');
        CRUD::field('person_name')->label('Meno účastníka(nečlena)')
            ->hint('Povinné pokiaľ účastník NEMÁ vytvorený účet. V opačnom prípade prosím vyberte meno v políčku Používateľ.');
        CRUD::field('event')->label('Udalosť')->options(function ($query) {
            return $query->where('date_from', '>=', Carbon::now()->toDateTimeString());
        });
        CRUD::field('paid')->label('Zaplatené?');
        CRUD::field('approved')->label('Schválené?');
        CRUD::field('note')->label('Poznámka');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    public function store()
    {
        CRUD::setRequest(CRUD::validateRequest());

        $request = CRUD::getRequest();
        if ($request->user) {
            $request->request->set('person_name', null);
        }

        return $this->traitStore();
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

    public function update()
    {
        CRUD::setRequest(CRUD::validateRequest());

        $request = CRUD::getRequest();
        if ($request->user) {
            $request->request->set('person_name', null);
        }

        return $this->traitUpdate();
    }

    protected function columns($isShow = false)
    {
        CRUD::column('id')->label('ID');
        CRUD::column('user')->label('Používateľ');
        CRUD::column('person_name')->label('Meno účastníka(nečlena)');
        CRUD::column('event')->label('Udalosť');
        CRUD::column('dog')->label('Pes');
        CRUD::column('dog_name')->label('Meno psa(nečlena)');
        CRUD::column('paid')->label('Zaplatené?')->type('boolean')->options([
            0 => 'Nie',
            1 => 'Áno'
        ]);
        CRUD::column('approved')->label('Schválené?')->type('boolean')->options([
            0 => 'Nie',
            1 => 'Áno'
        ]);
        !$isShow ?: CRUD::addColumn([
            'name' => 'registration',
            'type' => 'closure',
            'label' => 'Prihláška',
            'escaped' => false,
            'function' => function (EventRegistration $entry) {
                if (($doc = Document::where('type', Document::TYPE_EVENT_REGISTRATION)->where('event_registration_id', $entry->id)->first()) !== null) {
                    return '<a target="_blank" href="/' . $doc->path . '">' . $doc->name . '</a>';
                }

                return '-';
            }
        ]);
        !$isShow ?: CRUD::column('note')->label('Poznámka');
        !$isShow ?: CRUD::column('created_at')->label('Dátum vytvorenia');
        !$isShow ?: CRUD::column('updated_at')->label('Dátum úpravy');
    }
}
