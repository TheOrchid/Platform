<?php

namespace Orchid\Platform\Layouts;

use Orchid\Platform\Fields\Builder;

abstract class Rows
{
    /**
     * @var string
     */
    public $template = "dashboard::container.layouts.row";

    /**
     * @param $post
     *
     * @return array
     * @throws \Orchid\Platform\Exceptions\TypeException
     * @throws \Throwable
     */
    public function build($post)
    {
        $form = new Builder($this->fields(), $post);

        return view($this->template, [
            'form' => $form->generateForm(),
        ])->render();
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        return [];
    }
}
