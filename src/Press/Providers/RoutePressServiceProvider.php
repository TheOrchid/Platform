<?php

declare(strict_types=1);

namespace Orchid\Press\Providers;

use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;
use Orchid\Platform\Dashboard;
use Orchid\Press\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RoutePressServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @internal param Router $router
     */
    public function boot()
    {
        $this->binding();

        parent::boot();
    }

    /**
     * Route binding.
     */
    public function binding()
    {
        Route::bind('category', function ($value) {
            $category = Dashboard::modelClass(Category::class);

            if (is_numeric($value)) {
                return $category->where('id', $value)->firstOrFail();
            }

            return $category->findOrFail($value);
        });

        Route::bind('type', function ($value) {
            $post = Dashboard::modelClass(Post::class);

            return $post->getEntity($value)->getEntityObject();
        });

        Route::bind('page', function ($value) {
            $model = Dashboard::modelClass(Page::class);

            if (is_numeric($value)) {
                $page = $model->where('id', $value)->first();
            } else {
                $page = $model->where('slug', $value)->first();
            }

            if (is_null($page)) {
                $model->slug = $value;
                $page = $model;
            }

            return $page;
        });

        Route::bind('post', function ($value) {
            $post = Dashboard::modelClass(Post::class);

            if (is_numeric($value)) {
                return $post->where('id', $value)->firstOrFail();
            }

            return $post->where('slug', $value)->firstOrFail();
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::domain((string) config('platform.domain'))
            ->prefix(Dashboard::prefix('/press'))
            ->middleware(config('platform.middleware.private'))
            ->group(realpath(PLATFORM_PATH.'/routes/press.php'));
    }
}
