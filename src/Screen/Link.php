<?php

declare(strict_types=1);

namespace Orchid\Screen;

/**
 * Class Link.
 *
 * @method static Link name(string $name)
 * @method static Link modal(string $name)
 * @method static Link title(string $name)
 * @method static Link method(string $name)
 * @method static Link icon(string $name)
 * @method static Link link(string $name)
 * @method static Link show(bool $name)
 */
class Link
{
    /**
     * @var
     */
    public $slug;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $method;

    /**
     * @var
     */
    public $icon;

    /**
     * @var
     */
    public $modal;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $link;

    /**
     * @var
     */
    public $show = true;

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $new = new static();

        return call_user_func_array([$new, 'rewriteProperty'], [$name, $arguments[0]]);
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this, 'rewriteProperty'], [$name, $arguments[0]]);
    }

    /**
     * @param null $arguments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function build($arguments = null)
    {
        if (! $this->show) {
            return '';
        }

        return view('platform::partials.screen.link', [
            'slug'      => $this->slug,
            'name'      => $this->name,
            'method'    => $this->method,
            'icon'      => $this->icon,
            'modal'     => $this->modal,
            'title'     => $this->title,
            'link'      => $this->link,
            'arguments' => $arguments,
        ]);
    }

    /**
     * @param $name
     * @param $property
     *
     * @return $this
     */
    protected function rewriteProperty($name, $property)
    {
        $this->$name = $property;

        return $this;
    }
}
