<?php

declare(strict_types=1);

namespace Orchid\Platform\Filters;

use Orchid\Screen\Field;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    public $parameters;

    /**
     * @var bool
     */
    public $display = true;

    /**
     * Current app language.
     *
     * @var
     */
    public $lang;

    /**
     * Filter constructor.
     */
    public function __construct()
    {
        $this->request = request();
        $this->lang = app()->getLocale();
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        if (is_null($this->parameters) || $this->request->filled($this->parameters)) {
            return $this->run($builder);
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    abstract public function run(Builder $builder): Builder;

    /**
     * @return Field|null
     */
    public function display() : ?Field
    {
        //
    }
}
