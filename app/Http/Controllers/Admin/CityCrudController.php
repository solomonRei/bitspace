<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CitiesRequest;
use App\Models\CityStrings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

/**
 * Class CityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\City::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cities');
        CRUD::setEntityNameStrings(trans('custom.city'), trans('custom.cities'));
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
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

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
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
            'name' => "cityStrings",
            // 'attribute' => 'name'

            'columns' => [
                'languageCode' => trans('language'),
                'name' => trans('name')
            ]
        ]); 

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $id = $this->crud->getCurrentEntryId();

        $entry = $id ? $this->crud->getEntry($id) : null;

        CRUD::setValidation(CitiesRequest::class);

        CRUD::setFromDb(); // fields

        foreach ($this->crud->model->getLanguages() as $index => $language) {

            $languageCode = Str::upper($language->name);
            
            CRUD::addField([
                'label' => trans('custom.name') . " ($languageCode)",
                'name' => "city_strings[$index].name",
                'entity' => 'cityStrings',
                'attribute' => 'name',
                'type' => 'text',
                'value' => $entry && $entry->stringByLang($language->id) 
                    ? $entry->stringByLang($language->id)->name
                    : '',
                'tab' => $languageCode
            ]);

            CRUD::addField([
                'type' => 'hidden',
                'name' => "city_strings[$index].lang_id",
                'entity' => 'cityStrings',
                'attribute' => 'lang_id',
                'value' => $language->id,
                'tab' => $languageCode
            ]);

            if ($entry) {
                $string = $entry->stringByLang($language->id);

                if ($string) {
                    CRUD::addField([
                        'type' => 'hidden',
                        'name' => "city_strings[$index].id",
                        'entity' => 'cityStrings',
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
        // dd($request);
        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        if (isset($this->crud->getStrippedSaveRequest()['city_strings'])) {
            foreach ($this->crud->getStrippedSaveRequest()['city_strings'] as $key => $string) {
                $cityString = new CityStrings($string);

                $item->cityStrings()->save($cityString);
            }
        }
        
        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();
        $strings = isset($request['city_strings']) 
            ? $request['city_strings'] 
            : [];

        // update the row in the db
        $item = $this->crud->update($request->get($this->crud->model->getKeyName()),
                            $this->crud->getStrippedSaveRequest());
        $this->data['entry'] = $this->crud->entry = $item;

        foreach ($strings as $index => $string) {
            if (isset($string['id'])) {
                $cityStrings = CityStrings::where([
                    'id' => $string['id'],
                    'city_id' => $item->id
                ])->first();
                unset($string['id']);

                if ($cityStrings) {
                    $cityStrings->update($string);
                }
            } else {
                $cityStrings = new CityStrings($string);
                $item->cityStrings()->save($cityStrings);
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
