# Laravel Package Template
[![Latest Version on Packagist](https://img.shields.io/packagist/v/michael-rubel/laravel-package-template.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-package-template)
[![Total Downloads](https://img.shields.io/packagist/dt/michael-rubel/laravel-package-template.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-package-template)
[![Code Quality](https://img.shields.io/scrutinizer/quality/g/michael-rubel/laravel-package-template.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-package-template/?branch=main)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/michael-rubel/laravel-package-template.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-package-template/?branch=main)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/michael-rubel/laravel-package-template/run-tests/main?style=flat-square&label=tests&logo=github)](https://github.com/michael-rubel/laravel-package-template/actions)
[![PHPStan](https://img.shields.io/github/workflow/status/michael-rubel/laravel-package-template/phpstan/main?style=flat-square&label=larastan&logo=laravel)](https://github.com/michael-rubel/laravel-package-template/actions)

It is a ready template for Laravel packages.

### What's inside
- Basic skeleton with Service Provider and configuration file;
- Laravel Package Tools by Spatie for easier package management;
- PHPStan/larastan & Laravel Pint code quality checks;
- Ready-to-use GitHub Action scripts for testing;

Fill or change it the way you like.

---

The package requires PHP `8.x` and Laravel `9.x`.

## #StandWithUkraine
[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

## Installation
Install the package using composer:
```bash
composer require michael-rubel/laravel-package-template
```

## Usage
```php
// Your description.
```

Publish the config:
```bash
php artisan vendor:publish --tag="package-template-config"
```

## Testing
```bash
composer test
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
