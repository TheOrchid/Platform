<?php

namespace Orchid\Widget\Providers;

use Blade;
use Orchid\Widget\Console\MakeWidget;
use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerConfig();
        Blade::directive('widget', function ($expression) {
            $segments = explode(',', preg_replace("/[\(\)\\\]/", '', $expression));
            if (! array_key_exists(1, $segments)) {
                return '<?php echo (new \Orchid\Widget\Service\Widget)->get('.$segments[0].'); ?>';
            }

            return '<?php echo (new \Orchid\Widget\Service\Widget)->get('.$segments[0].','.$segments[1].'); ?>';

            /*
            return '<?php $'.trim($segments[0])." = app('".trim($segments[1])."'); ?>";


            dd($arguments);
            list($key, $arguments) = explode(',',str_replace(['(',')',' ', "'"], '', $arguments));
            $widget = (new Widget())->get($key,$arguments);


            return $widget;

            return "<?php echo (new \\Orchid\\Widget\\Service\\Widget)->get({$key},{$arguments}); ?>";
            */
        });
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/widget.php' => config_path('widget.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/widget.php', 'widget'
        );
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands(MakeWidget::class);
    }
}
