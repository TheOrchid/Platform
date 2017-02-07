<?php

namespace Orchid\Foundation\Filters;

use Illuminate\Support\Facades\App;

class ContentFilter
{
    /**
     * @var
     */
    public $model;

    /**
     * @var null
     */
    public $parameters;

    protected $chainBase = '';

    /**
     * ContentFilter constructor.
     *
     * @param $model
     * @param null $parameters
     */
    public function __construct($model, $parameters = null)
    {
        $this->model = $model;
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function run()
    {
        foreach ($this->parameters as $methodName => $values) {
            if (method_exists($this, $methodName)) {
                $chain = [];

                $chain[] = $this->chainBase;
                $chain[] = $methodName;

                $locale = App::getLocale();

                if ($locale == null) {
                    $locale = 'en';
                }

                $this->model = $this->$methodName($this->model, $values, "content->$locale->".implode($chain, '->'));
            }
        }

        return $this->model;
    }
}
