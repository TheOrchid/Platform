<?php

namespace Orchid\Platform\Fields\Types;

use Orchid\Platform\Fields\Field;

class PasswordField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.password';

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];
}
