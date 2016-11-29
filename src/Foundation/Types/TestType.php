<?php

namespace Orchid\Foundation\Types;

use Orchid\Foundation\Http\Forms\Posts\BasePostForm;
use Orchid\Foundation\Services\Type\Type;

class TestType extends Type
{
    /**
     * @var string
     */
    public $name = 'Новости';


    /**
     * @var string
     */
    public $slug = 'news';


    /**
     * Slug url /news/{name}.
     * @var string
     */
    public $slugFields = 'name';

    /**
     * Rules Validation.
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'sometimes|integer|unique:posts',
            'content.*.name' => 'email',
            'content.*.body' => 'required',
        ];
    }

    /**
     * @return array
     */
    public function setFields()
    {
        return [
            'name' => 'tag:input|type:text|name:name|max:255|required|title:Название статьи|help:Упоменение',
            'body' =>  'tag:textarea|name:body|max:255|required|class:editor|rows:10',
        ];
    }

    /**
     * Grid View for post type.
     */
    public function grid()
    {
        return [
            'name' => 'Название новости',
            'publish' => 'Дата публикации',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @return array
     */
    public function setModules()
    {
        return [
            BasePostForm::class,
        ];
    }
}
