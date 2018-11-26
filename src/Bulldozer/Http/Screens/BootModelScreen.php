<?php

declare(strict_types=1);

namespace Orchid\Bulldozer\Http\Screens;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Orchid\Bulldozer\Builders\Model;
use Orchid\Screen\Fields\InputField;
use Illuminate\Http\RedirectResponse;
use Orchid\Bulldozer\Builders\Migration;

/**
 * Class BootModelScreen.
 */
class BootModelScreen extends Screen
{
    /**
     * Key for cache.
     */
    const MODELS = 'platform::boot.models';

    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Model builder';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Helps to quickly develop application';

    /**
     * @var string
     */
    public $permission = 'platform.bulldozer';

    /**
     * @var Collection
     */
    public $models;

    /**
     * @var bool
     */
    public $exist = false;

    /**
     * BootModelScreen constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->models = cache(static::MODELS, collect());
    }

    /**
     * Query data.
     *
     * @param $model
     *
     * @return array
     */
    public function query($model = null): array
    {
        if ($model) {
            $this->exist = true;
            $this->name = "Boot for '{$model}' model";
        }

        return [
            'models'        => $this->models,
            'name'          => $model,
            'model'         => $this->models->get($model),
            'fieldTypes'    => Migration::TYPES,
            'relationTypes' => Model::RELATIONS,
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name(__('Build all models'))
                ->icon('icon-magic-wand')
                ->show($this->exist)
                ->method('buildModels'),

            Link::name(__('Add new model'))
                ->icon('icon-plus')
                ->modal('CreateModelModal')
                ->title(__('Add new model'))
                ->method('createModel'),

            Link::name(__('Delete'))
                ->icon('icon-trash')
                ->show($this->exist)
                ->method('delete'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layouts::view('platform::container.boot.index'),
            Layouts::modals([
                'CreateModelModal' => [
                    Layouts::rows([
                        InputField::make('name')
                            ->title(__('Model name:'))
                            ->help(__('Create a new model for your application'))
                            ->pattern('^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$')
                            ->hr(false)
                            ->required(),
                    ]),
                ],
            ]),
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function createModel(Request $request): RedirectResponse
    {
        $name = studly_case($request->get('name'));

        if ($this->models->offsetExists($name)) {
            alert(__('A model with the same name already exists.'));

            return back();
        }

        $this->models->put($name, collect());

        cache()->forever(static::MODELS, $this->models);

        alert(__('Model successfully created.'));

        return redirect()->route('platform.bulldozer.index', $name);
    }

    /**
     * @param string $model
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(string $model): RedirectResponse
    {
        $this->models = $this->models->except($model);
        cache()->forever(static::MODELS, $this->models);

        alert(__('Model has been deleted'));

        return redirect()->route('platform.bulldozer.index');
    }

    /**
     * @param string $model
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Exception
     */
    public function save(string $model, Request $request)
    {
        $attributes = collect($request->except('_token'));
        $this->models->put($model, $attributes);

        cache()->forever(static::MODELS, $this->models);

        return abort(200);
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function buildModels()
    {
        foreach ($this->models as $name => $model) {
            $property = [
                'fillable' => [],
                'guarded'  => [],
                'hidden'   => [],
                'visible'  => [],
            ];

            $migration = [];

            $columns = $model->get('columns', []);

            foreach ($columns as $key => $column) {
                if (isset($column['fillable'])) {
                    $property['fillable'][] = $key;
                }
                if (isset($column['guarded'])) {
                    $property['guarded'][] = $key;
                }
                if (isset($column['hidden'])) {
                    $property['hidden'][] = $key;
                }
                if (isset($column['visible'])) {
                    $property['visible'][] = $key;
                }

                $migrate = $column['name'].':'.Migration::TYPES[$column['type']];

                if (isset($column['unique'])) {
                    $migrate .= ':unique';
                }

                if (isset($column['nullable'])) {
                    $migrate .= ':nullable';
                }

                $migration[] = $migrate;
            }

            $model = new Model($name, [
                'property'  => array_filter($property),
                'relations' => $model->get('relations', []),
            ]);

            $model = $model->generate();

            file_put_contents(app_path($name.'.php'), $model);
            Migration::make($name, implode(',', $migration));
        }

        cache()->forget(static::MODELS);

        alert(__('All models have been successfully generated.'));

        return redirect()->route('platform.bulldozer.index');
    }

    /**
     * @param string $model
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRelated(string $model)
    {
        return view('platform::partials.boot.relatedOption', [
            'name'   => $model,
            'models' => $this->models,
        ]);
    }
}
