<?php

namespace Orchid\Types;

use Orchid\Http\Forms\Posts\BasePostForm;
use Orchid\Http\Forms\Posts\UploadPostForm;
use Orchid\Type\Type;

class DemoType extends Type
{
    /**
     * @var string
     */
    public $name = 'Demo type';

    /**
     * @var string
     */
    public $description = 'Demonstrative type';

    /**
     * @var string
     */
    public $slug = 'demo';

    /**
     * Slug url /news/{name}.
     *
     * @var string
     */
    public $slugFields = 'name';

    /**
     * @var bool
     */
    public $api = true;

    /**
     * Rules Validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id'             => 'sometimes|integer|unique:posts',
            'content.*.name' => 'required|string',
            'content.*.body' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'name' => 'tag:input|type:text|name:name|max:255|required|title:Name Articles|help:Article title',
            'body' => 'tag:textarea|name:body|max:255|required|class:summernote|rows:10',

            'place'    => 'tag:place|type:text|name:place|max:255|required|title:Location|help:Address on the map|placeholder:Location',
            'datetime' => 'tag:datetime|type:text|name:open|max:255|required|title:Opening date|help:The opening event will take place',

            'title'       => 'tag:input|type:text|name:title|max:255|required|title:Article Title|help:SEO title',
            'description' => 'tag:textarea|name:description|max:255|required|rows:5|title:Short description',
            'keywords'    => 'tag:tags|name:keywords|max:255|required|title:Keywords|help:SEO keywords',
            'robot'       => 'tag:robot|name:robot|max:255|required|title:Индексация|help:Allow search bots to index page',

            'free' => 'tag:checkbox|name:robot|max:255|required|title:Free|help:Event for free|placeholder:Event for free|default:1',

        ];
    }

    /**
     * @return array
     */
    public function modules()
    {
        return [
            UploadPostForm::class,
            BasePostForm::class,
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid()
    {
        return [
            'name'       => 'Name',
            'publish_at' => 'Date of publication',
            'created_at' => 'Date of creation',
        ];
    }
}
