# Поля
----------

Поля используются для генерации вывода шаблона формы заполнения и редактирования

Все возможные поля определены в `config/platform.php` в разделе полей.
Каждое поле может использоваться в поведении, макете или фильтре. 

Если вам нужно создать своё собственное поле, не стесняйтесь.
Поле состоит из одного класса с обязательным методом `create`, который должен реализовать `представление` для отображения пользователю.


```php
// Доступные поля для формирования шаблонов
'fields' => [
    'textarea'     => Orchid\Screen\Fields\TextAreaField::class,
    'input'        => Orchid\Screen\Fields\InputField::class,
    'list'         => Orchid\Screen\Fields\ListField::class,
    'tags'         => Orchid\Screen\Fields\TagsField::class,
    'select'       => Orchid\Screen\Fields\SelectField::class,
    'relationship' => Orchid\Screen\Fields\RelationshipField::class,
    'picture'      => Orchid\Screen\Fields\PictureField::class,
    'datetime'     => Orchid\Screen\Fields\DateTimerField::class,
    'checkbox'     => Orchid\Screen\Fields\CheckBoxField::class,
    'code'         => Orchid\Screen\Fields\CodeField::class,
    'wysiwyg'      => Orchid\Screen\Fields\TinyMCEField::class,
    'password'     => Orchid\Screen\Fields\PasswordField::class,
    'markdown'     => Orchid\Screen\Fields\SimpleMDEField::class,
],
```


Поля и поведения указываются отдельно, что позволяет использовать лишь ключ, 
например в записи мы хотим wysing редактор, а значением будет класс. 
Это позволяет менять редактор с tinymce на summernote или ckeditor почти в один клик.


> Не стесняйтесь добавлять свои поля, например, для использования удобного редактора для вас или любых компонентов.
 
 
## Input

Input - является одним из разносторонних элементов формы и позволяет создавать разные части интерфейса и обеспечивать взаимодействие с пользователем. 
Главным образом input предназначен для создания текстовых полей.
 
Пример записи:
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
 

> Заметьте многие параметры такие как max,required,title,help,vertical,horizontal; и многие другие, доступны почти каждым `полям` системы и являются не обязательными
 
 
 
## Wysiwyg

Визуальный редактор в котором содержание отображается в процессе редактирования и 
выглядит максимально близко похожим на конечный результат.
Редактор позволяет вставлять рисунки, таблицы, указывать стили оформления текста, видео.
 
Пример записи:
```php
return [
    'body' => Field::tag('wysiwyg')
                  ->name('body')
                  ->required()
                  ->title('Name Articles')
                  ->help('Article title')
                  ->theme('inlite'),
];
``` 
Для отображения в редакторе верхней панели и меню, в котором доступны функции полноэкранного режима и просмотр html кода, нужно установить атрибут `theme('modern')`.
 
## Markdown

Редактор для облегчённого языка разметки,
 созданный с целью написания максимально читаемого и удобного для правки текста,
  но пригодного для преобразования в языки для продвинутых публикаций
 
Пример записи:
```php
return [
    'body' => Field::tag('markdown')
                  ->name('body')
                  ->title('О чём вы хотите рассказать?'),
];
```  
 
## Picture
 
Позволяет загружать изображение и обрезать до нужного формата 


Пример записи:
```php
return [
    'picture' => Field::tag('picture')
                    ->name('picture')
                    ->width(500)
                    ->height(300),
];
```  
           
       
## Datetime
 
Позволяет выбрать дату и время


Пример записи:
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
 
Элемент графического пользовательского интерфейса, позволяющий пользователю управлять параметром с двумя состояниями — ☑ включено и ☐ выключено.


Пример записи:
```php
return [
    'free' => Field::tag('checkbox')
                   ->name('free')
                   ->value(1)
                   ->title('Free')
                   ->placeholder('Event for free')
                   ->help('Event for free'),
];
```           

## Code
 
Поле для записи программного кода с возможностью подсветки

Пример записи:
```php
return [
    'block' => Field::tag('code')
                   ->name('block')
                   ->title('Code Block')
                   ->help('Simple web editor'),
];
```    



## Textarea
 
Поле textarea представляет собой элемент формы для создания области, в которую можно вводить несколько строк текста. 
В отличие от тега input в текстовом поле допустимо делать переносы строк сохраняются при отправке данных на сервер.

Пример записи:
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
 
Запись значений через запятую

Пример записи:
```php
return [
    'keywords' => Field::tag('tags')
                      ->name('keywords')
                      ->title('Keywords')
                      ->help('SEO keywords'),
];
```   


## Select

Простой выбор из списка массива:

```php
return [
    'selest' => Field::tag('select')
                ->options([
                    'index'   => 'Index',
                    'noindex' => 'No index',
                ])
                ->name('select')
                ->title('Select tags')
                ->help('Allow search bots to index'),
];
```


## List
 
Динамическое добавление и сортировка значений

Пример записи:
```php
return [
    'list' => Field::tag('list')
                  ->name('list')
                  ->title('Dynamic list')
                  ->help('Dynamic list'),
];
```   


## Mask
 
Маска для ввода значений к тегу input. 
Отлично подходит если значения должны быть записаны в стандартном виде, например ИНН или номер телефона

Пример записи:
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

В маску можно передавать json с параметрами, например:


```php
return [
    'price' => Field::tag('input')
              ->type('text')
              ->name('price')
              ->mask(json_encode([
                 'mask' => '999 999 999.99',
                 'numericInput' => true
              ]))
              ->title('Стоимость')
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
             ->title('Стоимость'),
];
```   

Все доступные параметры *Inputmask* можно посмотреть [здесь](https://github.com/RobinHerbots/Inputmask#options)


## Отношения

Поля отношения могут подгружать динамические данные, это хорошее решение, если вам нужны связи.

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


AjaxWidget в свойство `$query` будет принимать значение для поиска, а `$key` выбранное значение.


```php
namespace App\Http\Widgets;

use Orchid\Widget\Widget;

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
                'text' => 'Запись 1',
            ],
            [
                'id'   => 2,
                'text' => 'Запись 2',
            ],
            [
                'id'   => 3,
                'text' => 'Запись 3',
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


## Модификация

Можно определить модификацию значения или других параметров с помощью магического метода `modify` добавив к этому
атрибут который необходимо переопределить:

```php
Field::tag('input')
    ->type('text')
    ->name('name')
    ->modifyValue(function ($value) {
        return strtoupper($value);
    })
```

Это позволяет создавать «вычисленные поля».

