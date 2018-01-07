<?php

namespace Orchid\Platform\Fields;

use Orchid\Platform\Screen\Repository;
use Orchid\Platform\Exceptions\TypeException;

class Builder
{
    /**
     * @var
     */
    public $fields;

    /**
     * @var
     */
    public $data;

    /**
     * @var
     */
    public $language;

    /**
     * @var
     */
    public $prefix;

    /**
     * @var
     */
    public $form;

    /**
     * Builder constructor.
     *
     * @param array  $fields
     * @param        $data
     * @param string $language
     * @param string $prefix
     */
    public function __construct(array $fields, $data, string $language = null, string $prefix = null)
    {
        $this->fields = Parser::parseFields($fields);
        $this->data = $data ?? $data = new Repository([]);

        $this->language = $language;
        $this->prefix = $prefix;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Generate a ready-made html form for display to the user.
     *
     * @return string
     * @throws TypeException
     */
    public function generateForm() : string
    {
        $fields = $this->fields;
        $availableFormFields = [];

        $this->form = '';
        foreach ($fields as $field => $config) {
            $fieldClass = config('platform.fields.'.$config['tag']);

            if (is_null($fieldClass)) {
                throw new TypeException('Field '.$config['tag'].' does not exist');
            }

            $config['lang'] = $this->language;
            $config['prefix'] = $this->buildPrefix($config);
            $config = $this->fill($config);

            $firstTimeRender = false;
            if (! in_array($fieldClass, $availableFormFields)) {
                array_push($availableFormFields, $fieldClass);
                $firstTimeRender = true;
            }

            $field = (new $fieldClass())->create($config, $firstTimeRender);
            $this->form .= $field->render();
        }

        return $this->form;
    }

    /**
     * @param $config
     *
     * @return string
     */
    private function buildPrefix($config)
    {
        if (isset($config['prefix'])) {
            $prefixArray = array_filter(explode(' ', $config['prefix']));

            foreach ($prefixArray as $prefix) {
                $config['prefix'] .= '['.$prefix.']';
            }

            return $config['prefix'];
        }

        return $this->prefix;
    }

    /**
     * @param $config
     *
     * @return mixed
     */
    private function fill($config)
    {
        $name = array_filter(explode(' ', $config['name']));
        $name = array_shift($name);

        $config['value'] = $this->getValue($name, $config['value'] ?? null);

        $binding = explode('.', $name);
        if (! is_array($binding)) {
            return $config;
        }

        $config['name'] = '';
        foreach ($binding as $key => $bind) {
            if (! is_null($config['prefix'])) {
                $config['name'] .= '['.$bind.']';
                continue;
            }

            if ($key === 0) {
                $config['name'] .= $bind;
                continue;
            }

            $config['name'] .= '['.$bind.']';
        }

        return $config;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    private function getValue(string $key, $value = null)
    {
        $data = $this->data->getContent($key, $this->language);

        if (! is_null($value) && $value instanceof \Closure) {
            return $value($data, $this->data);
        }

        return $data;
    }
}
