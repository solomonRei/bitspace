<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends CrudController
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
        $this->crud->setModel('App\Models\Category');
        $this->crud->setRoute(config('backpack.base.route_prefix'). '/categories');
        $this->crud->setEntityNameStrings('Категория', 'Категории');
    }

    public function setupListOperation()
    {

        $this->crud->setColumns([
            [
                'label' => 'Id',
                'name' => 'id',
                'type' => 'closure',
                'function' => function($entry) {
                    return $entry->id;
                }
            ],
            [
                'label' => 'Название',
                'name' => 'name',
                'type' => 'closure',
                'function' => function($entry) {
                    $category = $this->categoryService->getCategoryById($entry->id);
                    return $category->name;
                }
            ]
        ]);

        $this->crud->setHeading('Category', 'list');

    }

    public function setupCreateOperation()
    {
//        $this->crud->addField(['name' => 'category_id', 'type' => 'select', 'label' => 'Category',
//            'entity' => 'categoryStrings',
//            'model' => "App\Models\CategoryStrings", // related model
//            'attribute' => 'name', // foreign key attribute that is shown to user
//        ]);
        $this->crud->addField(['name' => 'name_ru', 'type' => 'text', 'label' => 'Title Ru']);
        $this->crud->addField(['name' => 'name_kz', 'type' => 'text', 'label' => 'Title Kz']);
        $this->crud->addField(['name' => 'name_en', 'type' => 'text', 'label' => 'Title En']);
//        $this->crud->addField(['name' => 'lang', 'label' => 'Lang',
//            'type' => 'select_from_array',
//            'options' => $langs,
//            'allows_null' => false,
//            //'default' => 1,
//
//        ]);
    }
}
