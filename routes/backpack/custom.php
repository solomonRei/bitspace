<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('categories', 'CategoryCrudController');
    Route::crud('about', 'AboutController');
    Route::crud('blog', 'BlogCrudController');
    Route::crud('tags', 'TagCrudController');
    Route::crud('cities', 'CityCrudController');
    Route::crud('groups', 'GroupCrudController');
    Route::crud('users', 'UserCrudController');
});
