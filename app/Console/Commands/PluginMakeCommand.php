<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class PluginMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:plugin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new searchable plugin';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Plugin';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/plugin.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Plugins';
    }
}
