<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoriesRequest;
use App\Models\CategoryStrings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Str;

class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }

    public function setup()
    {
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix'). '/categories');
        CRUD::setEntityNameStrings(trans('custom.category'), trans('custom.categories'));
    }

    public function setupListOperation()
    {

        CRUD::addColumn([
            'label' => trans('custom.name'),
            'name' => 'name',
            'type' => 'closure',
            'function' => function($entity) {
                return optional($entity->stringByLang())->name;
            }
        ]);

        CRUD::setFromDb(); // columns


        CRUD::setHeading('Category', 'list');

    }

    protected function setupShowOperation()
    {
        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        CRUD::setColumns([
            [
                'label' => 'ID',
                'name' => 'id',
            ],
        ]);

        CRUD::addColumn([
            'label' => trans('custom.name'),
            'type' => 'relationships_table',
            'name' => "categoryStrings",
            // 'attribute' => 'name'

            'columns' => [
                'languageCode' => trans('language'),
                'name' => trans('name')
            ]
        ]);

    }

    protected function setupCreateOperation()
    {
        $id = $this->crud->getCurrentEntryId();

        $entry = $id ? $this->crud->getEntry($id) : null;

        CRUD::setValidation(CategoriesRequest::class);

        CRUD::setFromDb(); // fields

        foreach ($this->crud->model->getLanguages() as $index => $language) {

            $languageCode = Str::upper($language->name);

            CRUD::addField([
                'label' => trans('custom.name') . " ($languageCode)",
                'name' => "category_strings[$index].name",
                'entity' => 'categoryStrings',
                'attribute' => 'name',
                'type' => 'text',
                'value' => $entry && $entry->stringByLang($language->id)
                    ? $entry->stringByLang($language->id)->name
                    : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'type' => 'hidden',
                'name' => "category_strings[$index].lang_id",
                'entity' => 'categoryStrings',
                'attribute' => 'lang_id',
                'value' => $language->id,
                'tab' => $languageCode
            ]);

            if ($entry) {
                $string = $entry->stringByLang($language->id);

                if ($string) {
                    CRUD::addField([
                        'type' => 'hidden',
                        'name' => "category_strings[$index].id",
                        'entity' => 'categoryStrings',
                        'attribute' => 'id',
                        'value' => $string->id,
                        'tab' => $languageCode
                    ]);
                }
            }

        }

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');
        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
//         dd($request);
        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        if (isset($this->crud->getStrippedSaveRequest()['category_strings'])) {
            foreach ($this->crud->getStrippedSaveRequest()['category_strings'] as $key => $string) {
                $categoryString = new CategoryStrings($string);

                $item->categoryStrings()->save($categoryString);
            }
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $strings = isset($request['category_strings'])
            ? $request['category_strings']
            : [];

        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        foreach ($strings as $index => $string) {
            if (isset($string['id'])) {
                $categoryStrings = CategoryStrings::where([
                    'id' => $string['id'],
                    'category_id' => $item->id
                ])->first();
                unset($string['id']);

                if ($categoryStrings) {
                    $categoryStrings->update($string);
                }
            } else {
                $categoryStrings = new CategoryStrings($string);
                $item->categoryStrings()->save($categoryStrings);
            }

        }

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
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
}
