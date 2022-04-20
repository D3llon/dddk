<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventRequest;
use App\Models\Document;
use App\Models\Event;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\ReviseOperation\ReviseOperation;
use Illuminate\Http\UploadedFile;

/**
 * Class EventCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EventCrudController extends CrudController
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
        CRUD::setModel(Event::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/event');
        CRUD::setEntityNameStrings('Udalosť', 'Udalosti');
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
        CRUD::field('name')->label('Názov');
        CRUD::field('eventType')->label('Typ udalosti');
        CRUD::addField([
            'name'                => 'date_from',
            'type'                => 'date_picker',
            'label'               => 'Dátum',
            'date_picker_options' => [
                'language' => 'sk',
                'format'   => 'dd.mm.yyyy',
                'todayBtn' => 'linked',
                'clearBtn' => true
            ]
        ]);
        CRUD::addField([
            'name'                => 'date_to',
            'type'                => 'date_picker',
            'label'               => 'Dátum do',
            'date_picker_options' => [
                'language' => 'sk',
                'format'   => 'dd.mm.yyyy',
                'todayBtn' => 'linked',
                'clearBtn' => true
            ]
        ]);
        CRUD::addField([
            'name'                => 'registration_deadline',
            'type'                => 'datetime_picker',
            'label'               => 'Deadline registrácií',
            'datetime_picker_options' => [
                'language' => 'sk',
                'format'   => 'DD.MM.YYYY HH:mm'
            ]
        ]);
        CRUD::field('description')->label('Popis');
        CRUD::field('price')->label('Cena')->type('number')
            ->suffix('€')
            ->attributes([
                'step' => '0.1'
            ]);
        CRUD::field('propositions')->label('Návrhy');
        CRUD::addField([
            'name' => 'registration',
            'type' => 'upload',
            'label' => 'Registračný formulár',
            'upload' => true,
            'attributes' => [
                'accept' => 'application/pdf'
            ]
        ]);

        CRUD::setValidation(EventRequest::class);

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

    public function store()
    {
        $request = CRUD::getRequest();
        $response = $this->traitStore();
        $id = $this->crud->getCurrentEntryId();

        if ($request->registration !== null) {
            /** @var UploadedFile $file */
            $file = $request->registration;
            $name = $file->getClientOriginalName();
            \Storage::disk('public')->put('documents/events/' . $id . '/' . $name, $file->getContent());

            Document::create([
                'type'     => Document::TYPE_EVENT,
                'event_id' => $id,
                'name' => $name,
                'path' => 'storage/documents/events/' . $id . '/' . $name
            ]);
        }

        return $response;
    }

    public function update()
    {
        $request = CRUD::getRequest();
        $response = $this->traitUpdate();

        if ($request->registration !== null) {
            /** @var UploadedFile $file */
            $file = $request->registration;
            $name = $file->getClientOriginalName();

            $entry = $this->crud->getCurrentEntry();

            if (($document = Document::where('type', Document::TYPE_EVENT)->where('event_id', $entry->id)->first()) !== null) {
                \Storage::disk('public')->delete('documents/events/' . $entry->id . '/' . $document->name);
            }

            \Storage::disk('public')->put('documents/events/' . $entry->id . '/' . $name, $file->getContent());

            $document ? $document->update([
                'name' => $name,
                'path' => 'storage/documents/events/' . $entry->id . '/' . $name
            ]) : Document::create([
                'type' => Document::TYPE_EVENT,
                'event_id' => $entry->id,
                'name' => $name,
                'path' => 'storage/documents/events/' . $entry->id . '/' . $name
            ]);
        }

        return $response;
    }

    protected function columns($isShow = false)
    {
        CRUD::set('show.setFromDb', false);
        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Názov');
        CRUD::column('eventType')->label('Typ udalosti');
        CRUD::column('date_from')->label('Dátum od')->type('date')->format('DD.MM.YYYY');
        CRUD::column('date_to')->label('Dátum do')->type('date')->format('DD.MM.YYYY');
        CRUD::column('registration_deadline')->label('Deadline reg.')->type('datetime')->format('DD.MM.YYYY H:m');
        CRUD::column('description')->label('Popis');
        CRUD::addColumn([
            'name'     => 'price',
            'type'     => 'closure',
            'label'    => 'Cena',
            'function' => function ($entry) {
                return $entry->price
                    ? number_format($entry->price, 2, ',', '.') . ' €'
                    : '-';
            }
        ]);
        CRUD::column('propositions')->label('Návrhy');
        if ($isShow) {
            CRUD::column('created_at')->label('Dátum vytvorenia');
            CRUD::column('updated_at')->label('Dátum úpravy');

            CRUD::addColumn([
                'name' => 'registration',
                'type' => 'closure',
                'label' => 'Prihláška',
                'escaped' => false,
                'function' => function (Event $event) {
                    if (($doc = Document::where('type', Document::TYPE_EVENT)->where('event_id', $event->id)->first()) !== null) {
                        return '<a target="_blank" href="/' . $doc->path . '">' . $doc->name . '</a>';
                    }

                    return '-';
                }
            ]);

            CRUD::addColumn([
                'name'     => 'eventRegistrations',
                'type'     => 'closure',
                'label'    => 'Registrácie',
                'escaped' => false,
                'function' => function (Event $entry) {
                    if ($entry->eventRegistrations) {
                        $out = '<ul>';
                        foreach ($entry->eventRegistrations as $registration) {
                            $out .= '<li>' . ($registration->user ? $registration->user->name : $registration->person_name) . ' (' . ($registration->dog ? $registration->dog->name : $registration->dog_name) . ')</li>';
                        }
                        $out .= '</ul>';
                        return $out;
                    }

                    return '-';
                }
            ]);
        }
        CRUD::column('deleted_at')->remove();
    }
}
