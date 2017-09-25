<?php

/*
|--------------------------------------------------------------------------
| Auth Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['web', 'dashboard'],
    'prefix'     => 'dashboard',
    'namespace'  => 'Orchid\Platform\Http\Controllers\Auth',
],
    function (\Illuminate\Routing\Router $router) {
        if (config('platform.auth.display', true)) {
            // Authentication Routes...
            $router->get('login', 'LoginController@showLoginForm')->name('dashboard.login');
            $router->post('login', 'LoginController@login');

            // Password Reset Routes...
            $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm');
            $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
            $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm');
            $router->post('password/reset', 'ResetPasswordController@reset');
        }

        $router->post('logout', 'LoginController@logout')->name('dashboard.logout');
    });
