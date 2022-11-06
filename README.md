![Value Objects for Laravel](https://user-images.githubusercontent.com/37669560/200172635-6b2ca8d8-fb2b-4037-a697-b8f6e4c8c615.png)

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

## Built-in value objects

- [`Boolean`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Primitive/Boolean.php)
- [`Number`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Primitive/Number.php)
- [`Text`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Primitive/Text.php)
- [`ClassString`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/ClassString.php)
- [`FullName`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/FullName.php)
- [`Name`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/Name.php)
- [`Phone`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/Phone.php)
- [`TaxNumber`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/TaxNumber.php)
- [`Uuid`](https://github.com/michael-rubel/laravel-value-objects/blob/main/src/Collection/Complex/Uuid.php)

### Artisan command
You can generate custom value objects with Artisan command:
```shell
php artisan make:value-object YourNameValueObject
```

## Usage

### Boolean
```php
$bool = new Boolean('1');
$bool = Boolean::make('1');
$bool = Boolean::from('1');

$bool->value();   // true
(string) $bool;   // 'true'
$bool->toArray(); // ['true']
```

---

### Number
```php
$number = new Number('10.20999', scale: 2);
$number = Number::make('10.20999', scale: 2);
$number = Number::from('10.20999', scale: 2);

$number->value();   // '10.20'
(string) $number;   // '10.20'
$number->toArray(); // ['10.20']
```

---

### Text
```php
$text = new Text('Lorem Ipsum is simply dummy text.');
$text = Text::make('Lorem Ipsum is simply dummy text.');
$text = Text::from('Lorem Ipsum is simply dummy text.');

$text->value();   // 'Lorem Ipsum is simply dummy text.'
(string) $text;   // 'Lorem Ipsum is simply dummy text.'
$text->toArray(); // ['Lorem Ipsum is simply dummy text.']
```

---

### ClassString
```php
$classString = new ClassString('\Exception');
$classString = ClassString::make('\Exception');
$classString = ClassString::from('\Exception');

$classString->value();   // '\Exception'
(string) $classString;   // '\Exception'
$classString->toArray(); // ['\Exception']

$classString->classExists();     // true
$classString->interfaceExists(); // false
$classString->instantiate();     // Exception { ... }
$classString->instantiateWith(['message' => 'My message.']); // Exception { #message: "test" ... }
```

---

### Email
```php
$email = new Email('michael@laravel.software');
$email = Email::make('michael@laravel.software');
$email = Email::from('michael@laravel.software');

$email->value();   // 'michael@laravel.software'
(string) $email;   // 'michael@laravel.software'
$email->toArray(); // ['michael@laravel.software']
```

---

### FullName
```php
$name = new FullName(' Taylor   Otwell ');
$name = FullName::make(' Taylor   Otwell ');
$name = FullName::from(' Taylor   Otwell ');

$name->value();   // 'Taylor Otwell'
(string) $name;   // 'Taylor Otwell'

$name->fullName();  // 'Taylor Otwell'
$name->firstName(); // 'Taylor'
$name->lastName();  // 'Otwell'

$name = 'Richard Le Poidevin';
$parts = str_word_count($name);

$fullName = new FullName($name, $parts);

$fullName->toArray();

// array:3 [
//  "fullName" => "Richard Le Poidevin"
//  "firstName" => "Richard"
//  "lastName" => "Le Poidevin"
// ]
```

---

### Name
```php
$name = new Name(' Company name! ');
$name = Name::make(' Company name! ');
$name = Name::from(' Company name! ');

$name->value();   // 'Company name!'
(string) $name;   // 'Company name!'
$name->toArray(); // ['Company name!']
```

---

### Phone
```php
$phone = new Phone(' +38 000 000 00 00 ');
$phone = Phone::make(' +38 000 000 00 00 ');
$phone = Phone::from(' +38 000 000 00 00 ');

$phone->value();   // '+38 000 000 00 00'
(string) $phone;   // '+38 000 000 00 00'
$phone->toArray(); // ['+38 000 000 00 00']

$phone->sanitized(); // '+380000000000'
```

---

### TaxNumber
```php
$taxNumber = new TaxNumber('0123456789', 'PL');
$taxNumber = TaxNumber::make('0123456789', 'PL');
$taxNumber = TaxNumber::from('0123456789', 'PL');

$taxNumber->value();   // 'PL0123456789'
(string) $taxNumber;   // 'PL0123456789'
$taxNumber->toArray(); // ['fullTaxNumber' => 'PL0123456789', 'taxNumber' => '0123456789', 'prefix' => 'PL']

$taxNumber->fullTaxNumber(); // 'PL0123456789'
$taxNumber->taxNumber();     // '0123456789'
$taxNumber->prefix();        // 'PL'
```

---

### Uuid
```php
$uuid = new Uuid('8547d10c-7a37-492a-8d33-be0e5ae6119b', 'Optional name');
$uuid = Uuid::make('8547d10c-7a37-492a-8d33-be0e5ae6119b', 'Optional name');
$uuid = Uuid::from('8547d10c-7a37-492a-8d33-be0e5ae6119b', 'Optional name');

$uuid->value();   // '8547d10c-7a37-492a-8d33-be0e5ae6119b'
(string) $uuid;   // '8547d10c-7a37-492a-8d33-be0e5ae6119b'
$uuid->toArray(); // ['name' => 'Optional name', 'value' => '8547d10c-7a37-492a-8d33-be0e5ae6119b']

$uuid->uuid(); // '8547d10c-7a37-492a-8d33-be0e5ae6119b'
$uuid->name(); // 'Optional name'
```

## Handle failed validation

If you want to avoid try/catching your value object when the validation fails, you can use `makeOrNull` method:

```php
$bool = Boolean::makeOrNull('bad input'); // null

$bool?->value(); // null
```

## Extending functionality
All value objects are [Macroable](https://laravel.com/api/9.x/Illuminate/Support/Traits/Macroable.html).
This way you can add new methods dynamically. If you need to extend existing methods, you can create a value object locally with `make:value-object` command and use inheritance.

For example:
```php
ValueObject::macro('str', function () {
    return str($this->value());
});

$name = new Text('Lorem ipsum');

$name->str()->is('Lorem ipsum'); // true
```

## Conditionable
Value objects utilize a [Conditionable](https://laravel.com/api/9.x/Illuminate/Support/Traits/Conditionable.html) trait.
You can use `when` and `unless` methods.

```php
TaxNumber::from('PL0123456789')->when(function ($number) {
    return $number->prefix() !== null;
})->prefix();
```

## Contributing
If you see any way we can improve the package, or maybe you want to make your own custom value object as built-in, PRs are welcome.

## Testing
```bash
composer test
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
