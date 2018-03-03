# Campos
----------
Os campos são usados para gerar a saída para o modelo do formulário.

Todos os campos possíveis estão definidos no arquivo `config/platform.php` dentro da seção de campos
Todos os campos podem ser usados num comportamento, modelo ou filtro.

Se precisas de criar o teu próprio campo, não seja tímido para o fazer.
O campo consiste numa classe com um método obrigatório `create` que deve implementar a `view` para mostrar ao utilizador.


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


Os campos e comportamentos são definidos separadamente o que nos permite usar apenas uma chave
para os aceder, por exemplo, se precisarmos de um valor solicitado pelo redactor `wysiwyg`, será a nossa classe.
Iso permite alterar o `tinymce` para `summernote` ou `ckeditor` quase num clique.


> Não sejas tímido para adicionares campos personalizados, por exemplo, usares um redactor confortável para ti ou para qualquer componente.
 
 
## Entrada

A entrada é um dos mais diversos elementos de formas que permite criar diferentes partes da interface e fornecer interação com o utilizador.
A entrada destina-se principalmente a criar campos de texto.
 
Um exemplo:
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
 

> Observa que muitos parâmetros, como o máximo, exigido, título, ajuda e outros, são acessíveis a partir de quase todos os `campos` do sistema e são completamente opcionais
 
 
 
## Wysiwyg

Um redactor visual cujo conteúdo é exibido no processo de redação e parece quase como um resultado.
O redactor permite adicionar imagens, tabelas, definir estilos de texto e inserir vídeos.
 
Um exemplo:
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
Para exibir um painel superior e um menu, que permite que visualizes um ecrã inicial e um código html, no redator, precisas definir um `modelo('moderno')`.
 
## Redução de preço

Redator de linguagem de marcação clara
  criado para escrever um texto máximo amigável e fácil de corrigir
   adequado para ser transpilado para idiomas para publicações avançadas
 
um exemplo:
```php
return [
    'body' => Field::tag('markdown')
                  ->name('body')
                  ->title('What would you tell us?'),
];
```  
 
## Imagens
 
Permite carregar imagens e cortá-las para o formato exigido


Um exemplo:
```php
return [
    'picture' => Field::tag('picture')
                    ->name('picture')
                    ->width(500)
                    ->height(300),,
];
```  
           
       
## Data hora
 
Permite definir data e hora


Um exemplo:
```php
return [
    'open' => Field::tag('datetime')
                  ->type('text')
                  ->name('open')
                  ->title('Opening date')
                  ->help('The opening event will take place'),
];
```           
           
## Caixa de verificação
 
Elemento de interface gráfica do utilizador que permite ao utilizador controlar o parâmetro com dois estados — ☑ ligado e ☐ desligado.


Um exemplo:
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

## Código
 
Um campo para um código de programa com um highligt

Um exemplo:
```php
return [
    'block' => Field::tag('code')
                   ->name('block')
                   ->title('Code Block')
                   ->help('Simple web editor'),
];
```    



## Textarea
 
Um campo `textarea` é um elemento de formulário usado para inserir várias strings de texto dentro dele.
Ao contrário da etiqueta `input`, é possível fazer um intervalo de linha, será guardado e enviado para o servidor.

Um exemplo:
```php
return [
    'description' => Field::tag('textarea')
                         ->name('description')
                         ->max(255)
                         ->row(5)
                         ->required()
                         ->title('Short description'),
];
```    


## Etiquetas
 
Uma notação de vários valores delimitados por vírgula

Um exemplo:
```php
return [
    'keywords' => Field::tag('tags')
                      ->name('keywords')
                      ->title('Keywords')
                      ->help('SEO keywords'),
];
```   


## Seleciona

Seleção simples da lista de matrizes:

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


## Lista
 
Agregação e classificação dinâmica de valores

Um exemplo:
```php
return [
    'list' => Field::tag('list')
                  ->name('list')
                  ->title('Dynamic list')
                  ->help('Dynamic list'),
];
```   


## Mascarar
 
Uma máscara para entrada de dados na etiqueta `input`.
É ótimo usá-la quando um valor deve ser inserido de alguma forma padrão, por exemplo ao inserir um número de telefone ou TIN

Um exemplo:
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

Um json com parâmetros pode ser passado para a máscara, por exemplo:


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

Tudo disponível *Inputmask* pode ser encontrado [aqui](https://github.com/RobinHerbots/Inputmask#options)


## Localização (Lugar)
 
O campo `localização` requere a chave para [Google](https://developers.google.com/maps/documentation/javascript/get-api-key?hl=ru) o mapa a ser definido em `config/service`
services.google.maps.key
```php
//
'google' => Field::tag('place')
                ->name('place')
                ->title('Place')
                ->help('place for google maps'),
```



## Comportamentos

Campos de comportamento podem carregar dados dinâmicos que são ótimos se precisares de conexões.

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


AjaxWidget receberá um valor de pesquisa dentro da propriedade `$ query` e a '$key` receberá um valor.


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
