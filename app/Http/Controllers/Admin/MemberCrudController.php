<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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

/**
 * Class MemberCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class MemberCrudController extends CrudController
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
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/member');
        CRUD::setEntityNameStrings('Člen', 'Členovia');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addClause('role', 'member');
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
        $this->fields();
        CRUD::setValidation(UserStoreRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    public function store()
    {
        CRUD::setRequest(CRUD::validateRequest());
        CRUD::setRequest($this->handlePasswordInput(CRUD::getRequest()));
        CRUD::unsetValidation();

        $response = $this->traitStore();

        $this->crud->getCurrentEntry()->assignRole('member');

        return $response;
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->fields();
        CRUD::setValidation(UserUpdateRequest::class);
    }

    public function update()
    {
        CRUD::setRequest(CRUD::validateRequest());
        CRUD::setRequest($this->handlePasswordInput(CRUD::getRequest()));
        CRUD::unsetValidation();

        return $this->traitUpdate();
    }

    protected function columns($isShow = false)
    {
        CRUD::column('id')->label('ID');
        CRUD::column('email')->label('Email');
        CRUD::column('name')->label('Celé meno');
        CRUD::column('street')->label('Ulica');
        CRUD::column('city')->label('Mesto');
        $isShow ? CRUD::column('zip')->label('PSČ') : CRUD::column('zip')->remove();
        $isShow ? CRUD::column('county')->label('Okres') : CRUD::column('county')->remove();
        $isShow ? CRUD::column('municipality')->label('Kraj') : CRUD::column('municipality')->remove();
        $isShow ? CRUD::column('nationality')->label('Národnosť') : CRUD::column('nationality')->remove();
        CRUD::column('phone')->label('Telefón');
        $isShow ? CRUD::column('familyMembership')->label('Rodinné členstvo (hlavný účet)') : CRUD::column('familyMembership')->remove();
        $isShow ? CRUD::column('other_club_membership')->label('Členstvo v inom klube') : CRUD::column('other_club_membership')->remove();
        $isShow ? CRUD::column('spz_membership')->label('Členstvo OkO - RgO SPZ v') : CRUD::column('spz_membership')->remove();

        $isShow ? CRUD::column('is_senior')->type('boolean')->label('Dôchodca')->options([
            0 => 'Nie',
            1 => 'Áno'
        ]) : CRUD::column('is_senior')->remove();
        $isShow ? CRUD::column('is_handicapped')->type('boolean')->label('ZŤP')->options([
            0 => 'Nie',
            1 => 'Áno'
        ]) : CRUD::column('is_handicapped')->remove();
        $isShow ? CRUD::column('accepted_data_publication')->label('Súhlas so zverejnením údajov')->type('boolean')->options([
            0 => 'Nie',
            1 => 'Áno'
        ]) : CRUD::column('accepted_data_publication')->remove();
    }

    protected function fields()
    {
        CRUD::field('email')->label('Email');
        CRUD::field('password')->label('Heslo');
        CRUD::field('password_confirmation')->label('Zopakovať heslo')->type('password');
        CRUD::field('first_name')->label('Meno');
        CRUD::field('last_name')->label('Priezvisko');
        CRUD::field('street')->label('Ulica');
        CRUD::field('city')->label('Mesto');
        CRUD::field('zip')->label('PSČ');
        CRUD::field('county')->label('Okres');
        CRUD::field('municipality')->label('Kraj');
        CRUD::field('nationality')->label('Národnosť')->type('relationship');
        CRUD::field('phone')->label('Telefón');
        CRUD::field('familyMembership')->label('Rodinné členstvo (hlavný účet)');
        CRUD::field('other_club_membership')->label('Členstvo v inom klube');
        CRUD::field('spz_membership')->label('Členstvo OkO - RgO SPZ v');
        CRUD::field('is_senior')->label('Dôchodca');
        CRUD::field('is_handicapped')->label('ZŤP');
        CRUD::field('accepted_data_publication')->label('Súhlas so zverejnením údajov');
    }

    protected function handlePasswordInput($request)
    {
        $request->request->remove('password_confirmation');
        if ($request->input('password')) {
            $request->request->set('password', \Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }
}
