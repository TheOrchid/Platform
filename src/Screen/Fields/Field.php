<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Exceptions\TypeException;
use Orchid\Screen\Exceptions\FieldRequiredAttributeException;

/**
 * Class Field.
 *
 * @method $this accesskey($value = true)
 * @method $this type($value = true)
 * @method $this class($value = true)
 * @method $this contenteditable($value = true)
 * @method $this contextmenu($value = true)
 * @method $this dir($value = true)
 * @method $this hidden($value = true)
 * @method $this id($value = true)
 * @method $this lang($value = true)
 * @method $this spellcheck($value = true)
 * @method $this style($value = true)
 * @method $this tabindex($value = true)
 * @method $this title($value = true)
 * @method $this hr($value = true)
 * @method $this options($value = true)
 */
class Field implements FieldContract
{
    /**
     * View template show.
     *
     * @var
     */
    public $view;

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
    ];

    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $name;

    /**
     * @var
     */
    public $old;

    /**
     * @var
     */
    public $error;

    /**
     * @var
     */
    public $slug;

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    public $translations = [
        'title',
        'placeholder',
        'help',
    ];

    /**
     * Universal attributes are applied to almost all tags,
     * so they are allocated to a separate group so that they do not repeat for all tags.
     *
     * @var array
     */
    public $universalAttributes = [
        'accesskey',
        'class',
        'contenteditable',
        'contextmenu',
        'dir',
        'hidden',
        'id',
        'lang',
        'spellcheck',
        'style',
        'tabindex',
        'title',
        'xml:lang',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [];

    /**
     * @param $arguments
     *
     * @return FieldContract
     *
     * @throws \Throwable|TypeException
     */
    public static function make($arguments)
    {
        $field = static::tag($arguments['tag']);

        foreach ($arguments as $key => $value) {
            $field->set($key, $value);
        }

        return $field;
    }

    /**
     * @param string $type
     *
     * @return FieldContract
     *
     * @throws \Throwable TypeException
     */
    public static function tag(string $type): FieldContract
    {
        $field = config('platform.fields.'.$type);

        if (! is_subclass_of($field, FieldContract::class)) {
            throw new TypeException('Field '.$type.' does not exist or inheritance FieldContract');
        }

        return new $field();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        foreach ($arguments as $key => $argument) {
            if ($argument instanceof \Closure) {
                $arguments[$key] = $argument();
            }
        }

        if (method_exists($this, $name)) {
            call_user_func_array([$this, $name], [$arguments]);
        }

        return call_user_func_array([$this, 'set'], [$name, array_shift($arguments) ?? true]);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function set($key, $value = true)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Obtain the list of required fields.
     *
     * @return array
     */
    public function getRequired() : array
    {
        return $this->required;
    }

    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getView() : string
    {
        return $this->view;
    }

    /**
     * @return mixed|void
     *
     * @throws \Throwable FieldRequiredAttributeException
     */
    public function checkRequired()
    {
        foreach ($this->required as $attribute) {
            throw_if(! collect($this->attributes)->offsetExists($attribute),
                FieldRequiredAttributeException::class,
                'Field must have the following attribute: '.$attribute);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     *
     * @throws \Throwable
     */
    public function render()
    {
        $this->checkRequired();
        $this->translate();

        $attributes = $this->getModifyAttributes();
        $this->attributes['id'] = $this->getId();

        return view($this->view, array_merge($this->getAttributes(), [
            'attributes' => $attributes,
            'id'         => $this->getId(),
            'old'        => $this->getOldValue(),
            'error'      => $this->hasError(),
            'slug'       => $this->getSlug(),
            'oldName'    => $this->getOldName(),
        ]));
    }

    /**
     * Localization of fields.
     */
    private function translate()
    {
        if (empty($this->translations)) {
            return;
        }

        $lang = $this->get('lang');

        foreach ($this->attributes as $key => $attribute) {
            if (in_array($key, $this->translations)) {
                $this->set($key, trans($attribute, [], $lang));
            }
        }
    }

    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getModifyAttributes()
    {
        $modifiers = get_class_methods($this);

        collect($this->getAttributes())->only(array_merge($this->universalAttributes,
            $this->inlineAttributes))->map(function ($item, $key) use ($modifiers) {
                $signature = 'modify'.title_case($key);
                if (in_array($signature, $modifiers)) {
                    $this->$signature($item);
                }
            });

        return  collect($this->getAttributes())->only(array_merge($this->universalAttributes, $this->inlineAttributes));
    }

    /**
     * @return string
     */
    public function getId()
    {
        $lang = $this->get('lang');
        $slug = $this->getSlug();

        return "field-$lang-$slug";
    }

    /**
     * @param      string $key
     * @param null $value
     *
     * @return $this|mixed|null
     */
    public function get($key, $value = null)
    {
        if (! isset($this->attributes[$key])) {
            return $value;
        }

        return $this->attributes[$key];
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return str_slug($this->get('name'));
    }

    /**
     * @return mixed
     */
    public function getOldValue()
    {
        return old($this->getOldName());
    }

    /**
     * @return string
     */
    public function getOldName()
    {
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');
        $name = str_ireplace(['[', ']'], '', $this->get('name'));

        if (is_null($prefix)) {
            return $lang.'.'.$name;
        }

        return $prefix.'.'.$lang.'.'.$name;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return optional(session('errors'))->has($this->getOldName()) ?? false;
    }

    /**
     * @return array
     */
    public function getOriginalAttributes()
    {
        return array_except($this->getAttributes(), array_merge($this->universalAttributes, $this->inlineAttributes));
    }

    /**
     * @param $name
     *
     * @return Field
     */
    public function modifyName($name)
    {
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');

        $this->attributes['name'] = $name;

        if (! is_null($prefix)) {
            $this->attributes['name'] = $prefix.$name;
        }

        if (is_null($prefix) && ! is_null($lang)) {
            $this->attributes['name'] = $lang.$name;
        }

        if (! is_null($prefix) && ! is_null($lang)) {
            $this->attributes['name'] = $prefix.'['.$lang.']'.$name;
        }

        if ($name instanceof \Closure) {
            $this->attributes['name'] = $name($this->attributes);
        }

        return $this;
    }

    /**
     * @param $value
     *
     * @return Field
     */
    public function modifyValue($value)
    {
        $old = $this->getOldValue();

        if (! is_null($old)) {
            $this->attributes['value'] = $old;
        }

        if ($value instanceof \Closure) {
            $this->attributes['value'] = $value($this->attributes);
        }

        $this->attributes['value'] = $value;

        return $this;
    }

    /**
     * @param \Closure $group
     *
     * @return mixed
     */
    public static function group($group)
    {
        return call_user_func_array($group, []);
    }
}
