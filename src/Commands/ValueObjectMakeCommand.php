<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ValueObjectMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'make:value-object';

    /**
     * @var string
     */
    protected $description = 'Create a value object';

    /**
     * @var string
     */
    protected $type = 'Value Object';

    /**
     * Specify your Stub's location.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/value-object.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     *
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath // @codeCoverageIgnore
            : __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\ValueObjects';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['value-object', null, InputOption::VALUE_NONE, 'Create a value object'],
        ];
    }
}
