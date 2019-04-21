<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\Foundation\Validation\ValidatesRequests;

trait Structure
{
    use ValidatesRequests;

    /**
     * Visible name of entity.
     *
     * @var string
     */
    public $name = '';

    /**
     * Visible description of entity.
     *
     * @var string
     */
    public $description = '';

    /**
     * A unique name for entity.
     *
     * @var string
     */
    public $slug = '';

    /**
     * Display Icon.
     *
     * @var string
     */
    public $icon = 'icon-folder';

    /**
     * @var string
     */
    public $prefix = 'content';

    /**
     * Menu title name
     *
     * @var null
     */
    public $title;

    /**
     * @deprecated use `title` property
     *
     * Menu group name.
     *
     * @var null
     */
    public $groupname;

    /**
     * Show the data to the user.
     *
     * @var bool
     */
    public $display = true;

    /**
     * Priority display in menu.
     *
     * @var int
     */
    public $sort = 0;

    /**
     * Basic statuses possible for the object.
     *
     * @return array
     */
    public function status(): array
    {
        return [
            'publish' => __('Published'),
            'draft'   => __('Draft'),
        ];
    }

    /**
     * Request Validation.
     *
     * @return array
     */
    public function isValid(): array
    {
        return $this->validate(request(), $this->rules());
    }

    /**
     * Validation Request Rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Registered fields for main.
     *
     * @return array
     */
    abstract public function main(): array;

    /**
     * Registered fields for filling.
     *
     * @return array
     */
    abstract public function fields(): array;

    /**
     * Registered fields for options.
     *
     * @return array
     */
    abstract public function options(): array;

    /**
     * Language support for recording.
     *
     * @return array
     */
    public function locale(): array
    {
        return config('press.locales', []);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->slug;
    }
}
