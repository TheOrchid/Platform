<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Types
    |--------------------------------------------------------------------------
    |
    | An abstract pattern of behavior record
    |
    */

    'types' => [
        \Orchid\Foundation\Types\TestType::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Available fields to form templates
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */

    'fields' => [
        'textarea' => \Orchid\Field\Fields\TextAreaField::class,
        'input' => \Orchid\Field\Fields\InputField::class,
        'tags' => \Orchid\Field\Fields\TagsField::class,
        'robot' => \Orchid\Field\Fields\RobotField::class,
        'place' => \Orchid\Field\Fields\PlaceField::class,
        'datetime' => \Orchid\Field\Fields\DateTimerField::class,
        'checkbox' => \Orchid\Field\Fields\CheckBoxField::class,
        'path' => \Orchid\Field\Fields\PathField::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Available menu
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */

    'menu' => [
        'header' => 'Верхнее меню',
        'sidebar' => 'Боковое меню',
        'footer' => 'Нижнее меню',
    ],

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    |
    | Image processing 100x150x75
    | 100 - integer width
    | 150 - integer height
    | 75  - integer quality
    |
    */

    'images' => [
        'low' => [
            'width' => '50',
            'height' => '50',
            'quality' => '50',
        ],
        'medium' => [
            'width' => '600',
            'height' => '300',
            'quality' => '75',
        ],
        'high' => [
            'width' => '1000',
            'height' => '500',
            'quality' => '100',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    |
    | Description
    |
    */

    'locales' => [

        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'dir' => 'ltr',
            'native' => 'English',
            'regional' => 'en_GB',
        ],

        'ru' => [
            'name' => 'Russian',
            'script' => 'Cyrl',
            'dir' => 'ltr',
            'native' => 'Русский',
            'regional' => 'ru_RU',
        ],
    ],

];
