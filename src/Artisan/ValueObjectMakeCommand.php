<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Artisan;

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
        return file_exists($customPath = $this->laravel->basePath('/stubs/value-object.stub'))
            ? $customPath // @codeCoverageIgnore
            : __DIR__ .'/stubs/value-object.stub';
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
