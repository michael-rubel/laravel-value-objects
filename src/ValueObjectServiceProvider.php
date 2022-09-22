<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects;

use MichaelRubel\ValueObjects\Commands\ValueObjectMakeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ValueObjectServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param  Package  $package
     *
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-value-objects')
            ->hasCommand(ValueObjectMakeCommand::class);
    }
}
