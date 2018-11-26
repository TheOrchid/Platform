<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class SelectField.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this name($value = true)
 * @method $this required($value = true)
 * @method $this size($value = true)
 * @method $this tabindex($value = true)
 * @method $this help($value = true)
 * @method $this popover($value = true)
 */
class SelectField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.select';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class' => 'form-control',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'name',
        'required',
        'size',
        'tabindex',
    ];

    /**
     * @return $this
     */
    public function multiple(): self
    {
        $this->attributes['multiple'] = 'multiple';

        return $this;
    }

    /**
     * @param null $name
     * @return SelectField
     */
    public static function make($name = null): self
    {
        return (new static)->name($name);
    }
}
