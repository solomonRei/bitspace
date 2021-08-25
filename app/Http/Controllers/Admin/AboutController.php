<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use App\Models\About;

class AboutController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \App\Traits\Languages;

    public function setup()
    {
        $this->crud->setModel(About::class);
        $this->crud->setRoute(config('backpack.base.route_prefix'). '/about');
    }

    public function setupListOperation()
    {
        $this->crud->addColumn(['name' => 'text', 'type' => 'text', 'label' => 'Text']);
        $this->crud->addColumn(['name' => 'phone', 'type' => 'text', 'label' => 'Phone']);
        $this->crud->addColumn(['name' => 'address', 'type' => 'text', 'label' => 'Address']);
        $this->crud->addColumn(['name' => 'link', 'type' => 'text', 'label' => 'Map Link']);
//        $this->crud->addColumn(['name' => 'lang', 'type' => 'closure', 'label' => 'Lang', 'function' => function($entry) {
//
//        }]);

        $this->crud->setHeading('About', 'list');
    }
}
