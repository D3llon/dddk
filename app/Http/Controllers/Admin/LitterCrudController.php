<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LitterRequest;
use App\Models\Dog;
use App\Models\Litter;
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
use Illuminate\Http\Request;

/**
 * Class LitterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class LitterCrudController extends CrudController
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
        CRUD::setModel(Litter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/litter');
        CRUD::setEntityNameStrings('Vrh', 'Vrhy');
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
        CRUD::setValidation(LitterRequest::class);

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
        $this->crud->set('show.setFromDb', false);
        CRUD::column('id')->label('ID');
        CRUD::column('breed')->label('Plemeno');
        CRUD::column('dam')->label('Matka');
        $isShow ? CRUD::column('foreign_dam_name')->label('Meno zahraničnej matky') : CRUD::column('foreign_dam_name')->remove();
        CRUD::column('sire')->label('Otec');
        $isShow ? CRUD::column('foreign_sire_name')->label('Meno zahraničného otca') : CRUD::column('foreign_sire_name')->remove();
        CRUD::column('mating_date')->label('Dátum párenia');
        CRUD::column('litter_date')->label('Dátum vrhu');
        $isShow ? CRUD::column('pups_female')->label('Počet narodených súk') : CRUD::column('pups_female')->remove();
        $isShow ? CRUD::column('pups_male')->label('Počet narodených psov') : CRUD::column('pups_male')->remove();
        $isShow ? CRUD::column('kept_female')->label('Počet ponechaný súk') : CRUD::column('kept_female')->remove();
        $isShow ? CRUD::column('kept_female_colors')->label('Farba ponechaných súk') : CRUD::column('kept_female_colors')->remove();
        $isShow ? CRUD::column('kept_male')->label('Počet ponechaných psov') : CRUD::column('kept_male')->remove();
        $isShow ? CRUD::column('kept_male_colors')->label('Farba ponechaných psov') : CRUD::column('kept_male_colors')->remove();
        $isShow ? CRUD::column('sireOwner')->label('Majiteľ Otca') : CRUD::column('sireOwner')->remove();
        $isShow ? CRUD::column('damOwner')->label('Majiteľ matky') : CRUD::column('damOwner')->remove();
        $isShow ? CRUD::column('created_at')->label('Dátum vytvorenia') : CRUD::column('created_at')->remove();
        $isShow ? CRUD::column('updated_at')->label('Dátum úpravy') : CRUD::column('updated_at')->remove();
        CRUD::column('deleted_at')->remove();
    }

    protected function fields()
    {
        CRUD::field('breed')->label('Plemeno');
        CRUD::field('dam')->label('Matka')->options(function ($query) {
            return $query->where('sex', 'F');
        });
        CRUD::field('sire')->label('Otec')->options(function ($query) {
            return $query->where('sex', 'M');
        });
        CRUD::field('foreign_sire_name')->label('Meno zahraničného otca');
        CRUD::addField([
            'name'                => 'mating_date',
            'type'                => 'date_picker',
            'label'               => 'Dátum párenia',
            'date_picker_options' => [
                'language' => 'sk',
                'format'   => 'dd.mm.yyyy',
                'todayBtn' => 'linked',
                'clearBtn' => true
            ]
        ]);
        CRUD::addField([
            'name'                => 'litter_date',
            'type'                => 'date_picker',
            'label'               => 'Dátum vrhu',
            'date_picker_options' => [
                'language' => 'sk',
                'format'   => 'dd.mm.yyyy',
                'todayBtn' => 'linked',
                'clearBtn' => true
            ]
        ]);
        CRUD::field('pups_female')->label('Počet narodených súk');
        CRUD::field('pups_male')->label('Počet narodených psov');
        CRUD::field('kept_female')->label('Počet ponechaných súk');
        CRUD::field('kept_female_colors')->label('Farba ponechaných súk');
        CRUD::field('kept_male')->label('Počet narodených psov');
        CRUD::field('kept_male_colors')->label('Farba ponechaných psov');
        CRUD::addField([
            'name'                    => 'sireOwner',
            'label'                   => 'Majiteľ otca',
            'type'                    => 'select2_from_ajax',
            'entity'                  => 'sireOwner',
            'attribute'               => 'name',
            'data_source'             => url(route('admin.get-select2-sire-owner')),
            'include_all_form_fields' => true,
            'minimum_input_length'    => 0,
            'dependencies'            => ['sire'],
            'placeholder'             => 'Select an entry'
        ]);

        CRUD::addField([
            'name'                    => 'damOwner',
            'label'                   => 'Majiteľ matky',
            'type'                    => 'select2_from_ajax',
            'entity'                  => 'damOwner',
            'attribute'               => 'name',
            'data_source'             => url(route('admin.get-select2-dam-owner')),
            'include_all_form_fields' => true,
            'minimum_input_length'    => 0,
            'dependencies'            => ['dam'],
            'placeholder'             => 'Select an entry'
        ]);
    }

    public function getSireOwner(Request $request)
    {
        $search = $request->get('q');
        $form = backpack_form_input();

        if (!$form['sire']) {
            return [];
        }

        $owners = Dog::find($form['sire'])->users();
        if ($search) {
            return $owners->where('name', 'LIKE', "%$search%")->paginate(10);
        } else {
            return $owners->paginate(10);
        }
    }

    public function getDamOwner(Request $request)
    {
        $search = $request->get('q');
        $form = backpack_form_input();

        if (!$form['dam']) {
            return [];
        }

        $owners = Dog::find($form['dam'])->users();
        if ($search) {
            return $owners->where('name', 'LIKE', "%$search%")->paginate(10);
        } else {
            return $owners->paginate(10);
        }
    }
}
