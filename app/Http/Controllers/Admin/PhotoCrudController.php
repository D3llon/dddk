<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PhotoRequest;
use App\Models\Photo;
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
use Intervention\Image\Facades\Image;

/**
 * Class PhotoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PhotoCrudController extends CrudController
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
        CRUD::setModel(Photo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/photo');
        CRUD::setEntityNameStrings('Fotka', 'Fotky');
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
        $this->fields();

        CRUD::setValidation(PhotoRequest::class);

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
        $image = Image::make($request->path)->encode('jpg');

        $now = Carbon::now()->format('Y_m_d_H_i_s');
        $fileName = md5($now) . '-' . $now . '.jpg';
        \Storage::disk('public')->put('images/' . $fileName, $image->stream());

        $request->request->set('height', $image->height());
        $request->request->set('width', $image->width());

        $thumbFileName = 'thumb_' . $fileName;
        $image->resize(125, 125, function ($constraint) {
            $constraint->aspectRatio();
        });
        \Storage::disk('public')->put('images/thumbnails/' . $thumbFileName, $image->stream(null, 100));

        $request->request->remove('image');
        $request->request->set('path', 'storage/images/' . $fileName);
        $request->request->set('path_thumb', 'storage/images/thumbnails/' . $thumbFileName);

        CRUD::setRequest($request);

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
        $entry = CRUD::getCurrentEntry();
        $fileName = explode('/', $entry->path)[2];

        $request = CRUD::getRequest();
        if (\Str::startsWith($request->path, 'data:image')) {
            $image = Image::make($request->path)->encode('jpg');
            \Storage::disk('public')->put('images/thumbnails/' . $fileName, $image->stream());

            $request->request->set('height', $image->height());
            $request->request->set('width', $image->width());

            $thumbFileName = 'thumb_' . $fileName;
            $image->resize(125, 125, function ($constraint) {
                $constraint->aspectRatio();
            });
            \Storage::disk('public')->put('images/thumbnails/' . $thumbFileName, $image->stream());

            $request->request->set('path', 'storage/images/' . $fileName);
            $request->request->set('path_thumb', 'storage/images/thumbnails/' . $thumbFileName);
        } else {
            $request->request->set('path', $entry->path);
        }

        CRUD::setRequest($request);

        return $this->traitUpdate();
    }

    protected function columns($isShow = false)
    {
        CRUD::set('show.setFromDb', false);
        CRUD::column('id')->label('ID');
        CRUD::column('path')->type('image')->label('Obrázok')->height($isShow ? 'auto' : '50px');
        CRUD::column('primary')->label('Je primárna');
        CRUD::column('copyright')->label('Copyright text');
        $isShow ? CRUD::column('width')->label('Šírka') : CRUD::column('width')->remove();
        $isShow ? CRUD::column('height')->label('Výška') : CRUD::column('height')->remove();
        $isShow ? CRUD::column('notes')->label('Poznámka') : CRUD::column('notes')->remove();
        CRUD::column('user')->label('Uverejnil');
        CRUD::column('dogs')->label('Psi');
        $isShow ? CRUD::column('created_at')->label('Dátum vytvorenia') : CRUD::column('created_at')->remove();
        $isShow ? CRUD::column('updated_at')->label('Dátum úpravy') : CRUD::column('updated_at')->remove();
    }

    protected function fields()
    {
        $this->crud->addField([
            'name'  => 'path',
            'type'  => 'image',
            'label' => 'Obrázok',
            'crop'  => true
        ]);
        CRUD::field('height')->type('hidden');
        CRUD::field('width')->type('hidden');
        CRUD::field('path_thumb')->type('hidden');
        CRUD::field('primary')->label('Je primárna');
        CRUD::field('copyright')->label('Copyright text');
        CRUD::field('notes')->label('Poznámka');
        CRUD::field('user')->label('Uverejnil')->default(backpack_user()->id);
        CRUD::field('dogs')->label('Psi na obrázku');
    }
}
