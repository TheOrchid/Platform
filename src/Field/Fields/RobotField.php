<?php

namespace Orchid\Field\Fields;

use Orchid\Field\Field;

class RobotField extends Field
{
    /**
     * @var string
     */
    public $view = 'dashboard::fields.robot';
    /**
     * HTML tag.
     *
     * @var string
     */
    protected $tag = 'robot';

    /**
     * Create Object.
     *
     * @param null $attributes
     * @param null $data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($attributes, $data = null)
    {
        if (is_null($data)) {
            $data = collect();
        }
        $attributes->put('data', $data);

        return view($this->view, $attributes);
    }
}
