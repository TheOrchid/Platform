<?php

namespace Orchid\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeType extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new type class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Type';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return DASHBOARD_PATH.'/resources/stubs/console/type.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Types';
    }
}
