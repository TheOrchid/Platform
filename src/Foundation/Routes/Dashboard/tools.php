<?php

/*
|--------------------------------------------------------------------------
| Tools Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard'],
    'prefix'     => 'dashboard/tools',
    'namespace'  => 'Orchid\Foundation\Http\Controllers\Tools',
],
    function ($router) {
        $router->resource('category', 'CategoryController', ['names' => [
            'index'   => 'dashboard.tools.category',
            'create'  => 'dashboard.tools.category.create',
            'edit'    => 'dashboard.tools.category.edit',
            'update'  => 'dashboard.tools.category.update',
            'store'   => 'dashboard.tools.category.store',
            'destroy' => 'dashboard.tools.category.destroy',
        ]]);

        $router->post('files', [
            'as'   => 'dashboard.tools.files.upload',
            'uses' => 'AttachmentController@upload',
        ]);

        $router->post('files/sort', [
            'as'   => 'dashboard.tools.files.sort',
            'uses' => 'AttachmentController@sort',
        ]);

        $router->delete('files/{id}', [
            'as'   => 'dashboard.tools.files.destroy',
            'uses' => 'AttachmentController@destroy',
        ]);

        $router->get('files/post/{id}', [
            'as'   => 'dashboard.tools.files.destroy',
            'uses' => 'AttachmentController@getFilesPost',
        ]);

        $router->resource('menu', 'MenuController', ['names' => [
            'index'  => 'dashboard.tools.menu.index',
            'show'   => 'dashboard.tools.menu.show',
            'update' => 'dashboard.tools.menu.update',
        ]]);

        $router->resource('advertising', 'AdvertisingController', ['names' => [
            'index'  => 'dashboard.tools.advertising.index',
            'create' => 'dashboard.tools.advertising.create',
            'update' => 'dashboard.tools.advertising.update',
            'store'  => 'dashboard.tools.advertising.store',
        ]]);
    });
