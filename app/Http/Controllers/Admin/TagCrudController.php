<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

/**
 * Class TagCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TagCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Tag::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tags');
        CRUD::setEntityNameStrings('tag', 'tags');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $languages = [];
        foreach ($this->crud->model->getLanguages() as $language) {
            $languages[$language->id] = Str::upper($language->name);
        }

        // CRUD::setFromDb(); // columns
        CRUD::addColumn([
            'name' => 'name',
        ]);

        CRUD::addColumn([
            'name' => 'slug',
        ]);

        CRUD::addColumn([
            'label' => 'Language',
            'name' => 'lang_id',
            'type' => 'closure',
            'function' => function($model) {
                return Str::upper($model->language->name);
            }
        ]);

        CRUD::filter('name')
            ->type('text')
            ->label('Name');

        CRUD::filter('slug')
            ->type('text')
            ->label('Slug');

        CRUD::filter('lang_id')
            ->type('dropdown')
            ->label('Language')
            ->values($languages);
        

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Show operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-show-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        // CRUD::setFromDb(); // columns
        CRUD::addColumn([
            'name' => 'name',
        ]);

        CRUD::addColumn([
            'name' => 'slug',
        ]);

        CRUD::addColumn([
            'label' => 'Language',
            'name' => 'lang_id',
            'type' => 'closure',
            'function' => function($model) {
                return Str::upper($model->language->name);
            }
        ]);

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
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TagRequest::class);

        // CRUD::setFromDb(); // fields
        CRUD::addField([
            'name' => 'name'
        ]);

        CRUD::addField([
            'name' => 'slug'
        ]);

        CRUD::addField([
            'name' => 'lang_id',
            'type' => 'relationship',
            'entity' => 'language'
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    protected function setupInlineCreateOperation()
    {
        $this->crud->setValidation(TagRequest::class);
        // $this->crud->addField($field_definition_array);
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
