<?php

declare(strict_types=1);

namespace MichaelRubel\PackageTemplate;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TemplateServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param Package $package
     *
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-package-template')
            ->hasConfigFile();
    }
}
