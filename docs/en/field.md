# Fields
----------
Fields are used to generate the output for the form template.

All possible fields are defined in the `config/platform.php` file inside the fields section
Every field may be used in a behavior, template or filter. 

If you need to create your own field don't be shy to do it.
Field consists of one class with a mandatory `create` method that must implement the `view`  to display to user.


```php
// Allowed template fields
'fields' => [
    'textarea'     => Orchid\Platform\Fields\Types\TextAreaField::class,
    'input'        => Orchid\Platform\Fields\Types\InputField::class,
    'list'         => Orchid\Platform\Fields\Types\ListField::class,
    'tags'         => Orchid\Platform\Fields\Types\TagsField::class,
    'select'       => Orchid\Platform\Fields\Types\SelectField::class,
    'relationship' => Orchid\Platform\Fields\Types\RelationshipField::class,
    'place'        => Orchid\Platform\Fields\Types\PlaceField::class,
    'picture'      => Orchid\Platform\Fields\Types\PictureField::class,
    'datetime'     => Orchid\Platform\Fields\Types\DateTimerField::class,
    'checkbox'     => Orchid\Platform\Fields\Types\CheckBoxField::class,
    'code'         => Orchid\Platform\Fields\Types\CodeField::class,
    'wysiwyg'      => Orchid\Platform\Fields\Types\TinyMCEField::class,
    'password'     => Orchid\Platform\Fields\Types\PasswordField::class,
    'markdown'     => Orchid\Platform\Fields\Types\SimpleMDEField::class,
],
```


Fields and behaviors are defined separately, that allows us to use only a key 
to access them, for example if we need a `wysiwyg` redactor requested value will be our class. 
This allows to change the `tinymce` to `summernote` or `ckeditor` almost in one click.


> Don't be shy to add custom fields, for example to use a redactor comfortable for you or any component.
 
 
## Input

Input is one of the most diversed elements of forms that allows you to create different parts of interface and provide interaction with user.
Input is mainly intended to create text fields.
 
An example:
```php
return [
    'body' => Field::tag('input')
                  ->type('text')
                  ->name('place')
                  ->max(255)
                  ->required()
                  ->title('Name Articles')
                  ->help('Article title'),
];
``` 
 

> Note that a lot of parameters, like max, required, title, help and others, are accessible from almost every `field` of the system and are completely optional
 
 
 
## Wysiwyg

A visual redactor which contents are displayed in the process of redaction and look almost like a result.
The redactor allows to add images, tables, define text styles and embed videos.
 
An example:
```php
return [
    'body' => Field::tag('wysiwyg')
                  ->name('body')
                  ->required()
                  ->title('Name Articles')
                  ->help('Article title')
                  ->theme('inline'),
];
``` 
To display a top panel and a menu, that allows you to view a splash screen and html code, in the redactor, you need to set an attribute `theme('modern')`.
 
## Markdown

Light markup language redactor 
 created to write a maximum human-friendly and easy-to-correct text
  suitable to be transpiled to languages for advanced publications
 
an example:
```php
return [
    'body' => Field::tag('markdown')
                  ->name('body')
                  ->title('What would you tell us?'),
];
```  
 
## Picture
 
Allows to upload pictures and cut them to a required format 


An example:
```php
return [
    'picture' => Field::tag('picture')
                    ->name('picture')
                    ->width(500)
                    ->height(300),,
];
```  
           
       
## Datetime
 
Allows to set date and time


An example:
```php
return [
    'open' => Field::tag('datetime')
                  ->type('text')
                  ->name('open')
                  ->title('Opening date')
                  ->help('The opening event will take place'),
];
```           
           
## Checkbox
 
User graphical interface element that allows a user to control the parameter with two states — ☑ on and ☐ off.


An example:
```php
return [
    'free' => Field::tag('checkbox')
                   ->name('free')
                   ->value(1)
                   ->title('Free')
                   ->placeholder('Event for free')
                   ->help('Event for free'),,
];
```           

## Code
 
A field for a program code with a highligt

An example:
```php
return [
    'block' => Field::tag('code')
                   ->name('block')
                   ->title('Code Block')
                   ->help('Simple web editor'),
];
```    



## Textarea
 
A `textarea` field is an element of form used to insert several text strings inside it. 
As opposed to `input` tag, it's possible to do a line break there, it will be saved and sent to server.

An example:
```php
return [
    'description' => Field::tag('textarea')
                         ->name('description')
                         ->max(255)
                         ->rows(5)
                         ->required()
                         ->title('Short description'),
];
```    


## Tags
 
A notation of several values delimited by comma

An example:
```php
return [
    'keywords' => Field::tag('tags')
                      ->name('keywords')
                      ->title('Keywords')
                      ->help('SEO keywords'),
];
```   


## Select

Simple selection from array list:

```php
return [
    'selest' => Field::tag('select')
                ->options([
                    'index'   => 'Index',
                    'noindex' => 'No index',
                ])
                ->name('select')
                ->title('Select tags')
                ->help('Allow search bots to index page'),
];
```


## List
 
Dynamical adding and sorting of values

An example:
```php
return [
    'list' => Field::tag('list')
                  ->name('list')
                  ->title('Dynamic list')
                  ->help('Dynamic list'),
];
```   


## Mask
 
A mask for data input in `input` tag. 
It's great to use it when a value must be inserted in some standard way, for example when inserting a phone number or TIN

An example:
```php
return [
    'phone' => Field::tag('input')
                   ->type('text')
                   ->name('phone')
                   ->mask('(999) 999-9999')
                   ->title('Phone')
                   ->help('Number Phone'),
];
```   

A json with parameters may be passed to mask, eg:


```php
return [
    'price' => Field::tag('input')
              ->type('text')
              ->name('price')
              ->mask(json_encode([
                 'mask' => '999 999 999.99',
                 'numericInput' => true
              ]))
              ->title('Cost')
];
```   

```php
return [
    'price' => Field::tag('input')
             ->type('text')
             ->name('price')
             ->mask(json_encode([
                'alias' => 'currency',
                'prefix' => ' ',
                'groupSeparator' => ' ',
                'digitsOptional' => true,
             ]))
             ->title('Cost'),
];
```   

All available *Inputmask* may be found [here](https://github.com/RobinHerbots/Inputmask#options)


## Location (Place)
 
A `location` field requires the key for [Google](https://developers.google.com/maps/documentation/javascript/get-api-key?hl=ru) map to be defined in `config/service`
services.google.maps.key
```php
//
'google' => Field::tag('place')
                ->name('place')
                ->title('Place')
                ->help('place for google maps'),
```



## Behaviors

Behavior fields may upload a dynamic data which is great if you need connections.

```php
    'type' => [
        'tag'      => 'relationship',
        'name'     => 'type',
        'required' => true,
        'title'    => 'avatar',
        'help'     => 'Article title',
        'handler'  => AjaxWidget::class,
    ],
```


AjaxWidget will receive a search value inside the `$query` property and the `$key` will  receive a value.


```php
namespace App\Http\Widgets;

use Orchid\Platform\Widget\Widget;

class AjaxWidget extends Widget
{

    /**
     * @var null
     */
    public $query = null;

    /**
     * @var null
     */
    public $key = null;

    /**
     * @return array
     */
    public function handler()
    {
        $data = [
            [
                'id'   => 1,
                'text' => 'Post 1',
            ],
            [
                'id'   => 2,
                'text' => 'Post 2',
            ],
            [
                'id'   => 3,
                'text' => 'Post 3',
            ],
        ];


        if(!is_null($this->key)) {
            foreach ($data as $key => $result) {

                if ($result['id'] === intval($this->key)) {
                    return $data[$key];
                }
            }
        }

        return $data;

    }

}

```
