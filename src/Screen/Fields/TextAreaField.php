<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class TextAreaField.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this cols($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this maxlength($value = true)
 * @method $this name($value = true)
 * @method $this placeholder($value = true)
 * @method $this readonly($value = true)
 * @method $this required($value = true)
 * @method $this rows($value = true)
 * @method $this tabindex($value = true)
 * @method $this wrap($value = true)
 * @method $this help($value = true)
 * @method $this max($value = true)
 * @method $this popover($value = true)
 */
class TextAreaField extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.textarea';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class' => 'form-control no-resize',
        'value' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'accesskey',
        'autofocus',
        'cols',
        'disabled',
        'form',
        'maxlength',
        'name',
        'placeholder',
        'readonly',
        'required',
        'rows',
        'tabindex',
        'wrap',
    ];

    /**
     * @param null $name
     * @return TextAreaField
     */
    public static function make($name = null): self
    {
        return (new static)->name($name);
    }
}
