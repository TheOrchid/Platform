<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 01.02.17
 * Time: 16:36.
 */

namespace Orchid\Foundation\Kernel;

class Storage
{
    /**
     * @var null
     */
    protected $configField = null;

    /**
     * @var
     */
    public $container;

    /**
     * TypeStorage constructor.
     */
    public function __construct()
    {
        $this->container = collect();

        $types = config($this->configField, []);

        foreach ($types as $type) {
            $this->add($type);
        }
    }

    /**
     * @param $class
     */
    public function add($class)
    {
        $this->container->push($class);
    }

    /**
     * @return array
     */
    public function all()
    {
        $this->container->transform(function ($value) {
            if (!is_object($value)) {
                $value = new $value();
            }

            return $value;
        });

        return $this->container->all();
    }

    /**
     * @param $arg
     *
     * @return mixed
     */
    public function get($arg)
    {
        return $this->container->get($arg);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function find($name)
    {
        return $this->container->where('slug', $name)->first();
    }
}
