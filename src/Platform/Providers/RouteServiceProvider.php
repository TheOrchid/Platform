<?php

namespace Orchid\Platform\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Orchid\Platform\Core\Models\Page;
use Orchid\Platform\Core\Models\Post;
use Orchid\Platform\Core\Models\Role;
use Orchid\Platform\Core\Models\Taxonomy;
use Orchid\Platform\Http\Middleware\AccessMiddleware;
use Orchid\Platform\Widget\WidgetContractInterface;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Orchid\Platform\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        Route::middlewareGroup('dashboard', [
            //Firewall::class,
            // RedirectInstall::class,
            AccessMiddleware::class,
        ]);


        $this->binding();

        parent::boot();
    }

    /**
     * Route binding.
     */
    public function binding()
    {
        Route::bind('role', function ($value) {
            return Role::where('slug', $value)->firstOrFail();
        });

        Route::bind('category', function ($value) {
            return Taxonomy::findOrFail($value);
        });

        Route::bind('type', function ($value) {
            $post = new Post();
            $type = $post->getBehavior($value)->getBehaviorObject();

            return $type;
        });

        Route::bind('widget', function ($value) {
            try {
                $widget = app()->make((urldecode($value)));
            } catch (\Exception $exception) {
                return abort(404);
            }

            if (!is_a($widget, WidgetContractInterface::class)) {
                return abort(404);
            }

            return $widget;
        });


        Route::bind('slug', function ($value) {
            if (is_numeric($value)) {
                return Post::where('id', $value)->firstOrFail();
            }

            return Post::findOrFail($value);
        });

        Route::bind('page', function ($value) {
            if (is_numeric($value)) {
                $page = Page::where('id', $value)->first();
            } else {
                $page = Page::where('slug', $value)->first();
            }
            if (is_null($page)) {
                return new Page([
                    'slug' => $value,
                ]);
            }

            return $page;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        if (config('platform.headless')) {
            return null;
        }

        foreach (glob(DASHBOARD_PATH . '/routes/*/*.php') as $file) {
            $this->loadRoutesFrom($file);
        }
    }
}
