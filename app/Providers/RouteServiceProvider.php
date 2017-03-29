<?php

namespace Orchid\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Core\Models\Post;
use Orchid\Core\Models\TermTaxonomy;
use Orchid\Defender\Middleware\Firewall;
use Orchid\Http\Middleware\AccessMiddleware;
use Orchid\Http\Middleware\CanInstall;
use Orchid\Http\Middleware\RedirectInstall;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        Route::middlewareGroup('dashboard', [
            Firewall::class,
            RedirectInstall::class,
        ]);

        Route::middlewareGroup('access', [
            Firewall::class,
            AccessMiddleware::class,
        ]);

        Route::middlewareGroup('install', [
            CanInstall::class,
        ]);

        $this->binding();

        parent::boot();
    }

    /**
     * Route binding.
     */
    public function binding()
    {
        Route::bind('category', function ($value) {
            return TermTaxonomy::findOrFail($value);
        });

        Route::bind('type', function ($value) {
            $post = new Post();
            $type = $post->getType($value)->getTypeObject();

            return $type;
        });

        Route::bind('slug', function ($value) {
            if (is_numeric($value)) {
                return Post::where('id', $value)->firstOrFail();
            }

            return Post::where('slug', $value)->firstOrFail();
        });

        Route::bind('advertising', function ($value) {
            if (is_numeric($value)) {
                return Post::where('type', 'advertising')->where('id', $value)->firstOrFail();
            }

            return Post::where('type', 'advertising')->where('slug', $value)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        //$router->middleware('dashboard', AccessMiddleware::class);

        foreach (glob(DASHBOARD_PATH.'/routes/*/*.php') as $file) {
            $this->loadRoutesFrom($file);
        }
    }
}
