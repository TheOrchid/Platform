<?php

namespace Orchid\Foundation\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Foundation\Http\Composers\MenuComposer;
use Orchid\Foundation\Kernel\Dashboard;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard)
    {
        View::composer('dashboard::layouts.dashboard', MenuComposer::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
