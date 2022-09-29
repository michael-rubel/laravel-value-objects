# Laravel Value Objects
[![Latest Version on Packagist](https://img.shields.io/packagist/v/michael-rubel/laravel-value-objects.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-value-objects)
[![Total Downloads](https://img.shields.io/packagist/dt/michael-rubel/laravel-value-objects.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-value-objects)
[![Code Quality](https://img.shields.io/scrutinizer/quality/g/michael-rubel/laravel-value-objects.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-value-objects/?branch=main)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/michael-rubel/laravel-value-objects.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-value-objects/?branch=main)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/michael-rubel/laravel-value-objects/run-tests/main?style=flat-square&label=tests&logo=github)](https://github.com/michael-rubel/laravel-value-objects/actions)
[![PHPStan](https://img.shields.io/github/workflow/status/michael-rubel/laravel-value-objects/phpstan/main?style=flat-square&label=larastan&logo=laravel)](https://github.com/michael-rubel/laravel-value-objects/actions)

A bunch of general-purpose value objects you can use in your Laravel application.

---

The package requires PHP `^8.0` and Laravel `^9.7`.

## #StandWithUkraine
[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

## Installation
Install the package using composer:
```bash
composer require michael-rubel/laravel-value-objects
```

## Available objects
- [`ClassString`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/ClassString.php)

```php
$classString = new ClassString('\Exception');
$classString = ClassString::make('\Exception');
$classString = ClassString::from('\Exception');

$classString->value(); // '\Exception'
(string) $classString; // '\Exception'
$name->toArray();      // ['\Exception']

$classString->classExists();     // true
$classString->interfaceExists(); // false
$classString->instantiate();     // Exception { ... }
$classString->instantiateWith(['message' => 'My message.']); // Exception { #message: "test" ... }
```

---

- [`FullName`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/FullName.php)

```php
$name = new FullName(' Taylor   Otwell ');
$name = FullName::make(' Taylor   Otwell ');
$name = FullName::from(' Taylor   Otwell ');

$name->value();   // 'Taylor Otwell'
(string) $name;   // 'Taylor Otwell'
$name->toArray(); // ['Taylor Otwell']

$name->fullName();  // 'Taylor Otwell'
$name->firstName(); // 'Taylor'
$name->lastName();  // 'Otwell'
```

---

- [`TaxNumber`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/TaxNumber.php)

```php
$taxNumber = new TaxNumber('0123456789', 'PL');

$taxNumber->value();   // 'PL0123456789'
(string) $taxNumber;   // 'PL0123456789'
$taxNumber->toArray(); // ['fullTaxNumber' => 'PL0123456789', 'taxNumber' => '0123456789', 'prefix' => 'PL']

$taxNumber->fullTaxNumber(); // 'PL0123456789'
$taxNumber->taxNumber();     // '0123456789'
$taxNumber->prefix();        // 'PL'
```

---

- [`Uuid`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/Uuid.php)

```php
$uuid = new Uuid('8547d10c-7a37-492a-8d33-be0e5ae6119b', 'Optional name');

$uuid->value();   // '8547d10c-7a37-492a-8d33-be0e5ae6119b'
(string) $uuid;   // '8547d10c-7a37-492a-8d33-be0e5ae6119b'
$uuid->toArray(); // ['name' => 'Optional name', 'value' => '8547d10c-7a37-492a-8d33-be0e5ae6119b']

$uuid->uuid(); // '8547d10c-7a37-492a-8d33-be0e5ae6119b'
$uuid->name(); // '8547d10c-7a37-492a-8d33-be0e5ae6119b'
```

---

- [`Boolean`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Primitive/Boolean.php)

```php
$bool = new Boolean('1');

$bool->value();   // true
(string) $uuid;   // 'true'
$uuid->toArray(); // ['true']
```

---

- [`Decimal`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Primitive/Decimal.php)

```php
$decimal = new Decimal('10.20999', scale: 2);

$decimal->value();   // '10.20'
(string) $decimal;   // '10.20'
$decimal->toArray(); // ['10.20']
```

---

- [`Integer`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Primitive/Integer.php)

```php
$integer = new Integer(10);

$integer->value();   // 10
(string) $integer;   // 10
$integer->toArray(); // [10]
```

---

- [`Text`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Primitive/Text.php)

```php
$text = new Text('Lorem Ipsum is simply dummy text.');

$text->value();   // 'Lorem Ipsum is simply dummy text.'
(string) $text;   // 'Lorem Ipsum is simply dummy text.'
$text->toArray(); // ['Lorem Ipsum is simply dummy text.']
```

## Testing
```bash
composer test
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
