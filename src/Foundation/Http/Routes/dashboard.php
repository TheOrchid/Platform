<?php

Route::get('/', [
    'as' => 'dashboard.index',
    'uses' => 'DashboardController@index',
]);

Route::group(['namespace' => 'Posts', 'prefix' => 'posts'], function () {
    Route::get('{type}/create', [
        'as' => 'dashboard.posts.type.create',
        'uses' => 'PostController@create',
    ]);

    Route::get('{type}/{slug}/edit', [
        'as' => 'dashboard.posts.type.edit',
        'uses' => 'PostController@edit',
    ]);

    Route::get('{type}/{slug?}', [
        'as' => 'dashboard.posts.type',
        'uses' => 'PostController@index',
    ]);

    Route::post('{type}', [
        'as' => 'dashboard.posts.type.store',
        'uses' => 'PostController@store',
    ]);

    Route::put('{type}/{slug?}', [
        'as' => 'dashboard.posts.type.update',
        'uses' => 'PostController@update',
    ]);

    Route::delete('{type}/{slug?}', [
        'as' => 'dashboard.posts.type.destroy',
        'uses' => 'PostController@destroy',
    ]);
});

Route::group(['namespace' => 'Systems', 'prefix' => 'systems'], function () {
    Route::get('settings', [
        'as' => 'dashboard.systems.settings',
        'uses' => 'SettingController@index',
    ]);

    Route::post('settings', [
        'as' => 'dashboard.systems.settings',
        'uses' => 'SettingController@store',
    ]);

    Route::resource('users', 'UserController', ['names' => [
        'index' => 'dashboard.systems.users',
        'create' => 'dashboard.systems.users.create',
        'edit' => 'dashboard.systems.users.edit',
        'update' => 'dashboard.systems.users.update',
        'store' => 'dashboard.systems.users.store',
        'destroy' => 'dashboard.systems.users.destroy',
    ]]);

    Route::resource('roles', 'RoleController', ['names' => [
        'index' => 'dashboard.systems.roles',
        'create' => 'dashboard.systems.roles.create',
        'edit' => 'dashboard.systems.roles.edit',
        'update' => 'dashboard.systems.roles.update',
        'store' => 'dashboard.systems.roles.store',
        'destroy' => 'dashboard.systems.roles.destroy',
    ]]);

    Route::resource('backup', 'BackupController', ['names' => [
        'index' => 'dashboard.systems.backup',
        'create' => 'dashboard.systems.backup.create',
        'download' => 'dashboard.systems.backup.download',
        'destroy' => 'dashboard.systems.backup.destroy',
    ]]);
});

Route::group(['namespace' => 'Tools', 'prefix' => 'tools'], function () {
    Route::post('files', [
        'as' => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);

    Route::resource('section', 'SectionController', ['names' => [
        'index' => 'dashboard.tools.section',
        'create' => 'dashboard.tools.section.create',
        'edit' => 'dashboard.tools.section.edit',
        'update' => 'dashboard.tools.section.update',
        'store' => 'dashboard.tools.section.store',
        'destroy' => 'dashboard.tools.section.destroy',
    ]]);

    Route::post('files', [
        'as' => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);
    Route::delete('files/{id}', [
        'as' => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@destroy',
    ]);

    Route::get('files/post/{id}', [
        'as' => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@getFilesPost',
    ]);
});
