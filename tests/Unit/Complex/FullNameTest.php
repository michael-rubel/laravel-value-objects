<?php

declare(strict_types=1);

use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Complex\FullName;

test('can get first name', function () {
    $name = new FullName('Michael Rubél');

    $this->assertSame('Michael', $name->firstName());
});

test('can get last name', function () {
    $name = new FullName('Michael Rubél');

    $this->assertSame('Rubél', $name->lastName());
});

test('can get full name', function () {
    $name = new FullName('Michael Rubél');

    $this->assertSame('Michael Rubél', $name->fullName());
});

test('can get full name minus case', function () {
    $name = new FullName('Anna Nowak-Kowalska');

    $this->assertSame('Anna', $name->firstName());
    $this->assertSame('Nowak-Kowalska', $name->lastName());
});

test('full name with break control', function () {
    $name = new FullName('Alicja Bachleda Curuś', 2);
    $this->assertSame('Alicja', $name->firstName());
    $this->assertSame('Bachleda Curuś', $name->lastName());
});

test('can get full name with name in between', function () {
    $name = new FullName('Anna Ewa Kowalska');

    $this->assertSame('Anna', $name->firstName());
    $this->assertSame('Kowalska', $name->lastName());
});

test('can break control using word count', function () {
    $name = 'Richard Le Poidevin';
    $name = new FullName($name, 2);
    $this->assertSame('Richard', $name->firstName());
    $this->assertSame('Le Poidevin', $name->lastName());
});

test('full name covnerts the first letter of each word to uppercase', function ($input, $result) {
    $name = new FullName($input);
    $this->assertSame($result, $name->fullName());
})->with([
    ['michael mcKenzie', 'Michael McKenzie'],
    ['michael McKenzie', 'Michael McKenzie'],
    ['Michael mcKenzie', 'Michael McKenzie'],
    ['Michael McKenzie', 'Michael McKenzie'],
    ['michael mckenzie', 'Michael Mckenzie'],
    ['michael mc-kenzie', 'Michael Mc-kenzie'],
    [' michael mc-Kenzie ', 'Michael Mc-Kenzie'],
]);

test('can get cast to string', function () {
    $name = new FullName('Michael Rubél');
    $this->assertSame('Michael Rubél', (string) $name);

    $name = new FullName('Michael Rubél');
    $this->assertSame('Michael Rubél', $name->toString());
});

test('cannot pass empty string', function () {
    $this->expectException(ValidationException::class);

    new FullName('');
});

test('validation exception message is correct in email', function () {
    try {
        new FullName('');
    } catch (ValidationException $e) {
        $this->assertSame(__('Full name cannot be empty.'), $e->getMessage());
    }

    try {
        new FullName('Test');
    } catch (ValidationException $e) {
        $this->assertSame(__('Full name should have a first name and last name.'), $e->getMessage());
    }
});

test('cannot pass null', function () {
    $this->expectException(\TypeError::class);
    $name = new FullName(null);
    $this->assertSame('', $name->fullName());
});

test('full name is makeable', function () {
    $name = FullName::make('Michael Rubél');
    $this->assertSame('Michael Rubél', $name->fullName());

    $name = FullName::from('Michael Rubél');
    $this->assertSame('Michael Rubél', $name->fullName());
});

test('full name is macroable', function () {
    FullName::macro('middlename', fn () => $this->split[1]);
    $valueObject = new FullName('Anna Ewa Kowalska');
    $this->assertSame('Ewa', $valueObject->middlename());

    FullName::macro('inverse', fn () => $this->split = $this->split->reverse());
    $valueObject = new FullName('Nowak-Kowalska Ewa Anna');
    $valueObject->inverse();
    $this->assertSame('Anna', $valueObject->firstName());
    $this->assertSame('Nowak-Kowalska', $valueObject->lastName());
    $this->assertSame('Ewa', $valueObject->middlename());
});

test('full name is conditionable', function () {
    $valueObject = new FullName('Michael Rubél');

    $this->assertSame('Michael', $valueObject->when(true)->firstName());
    $this->assertSame($valueObject, $valueObject->when(false)->firstName());
});

test('full name is arrayable', function () {
    $valueObject = new FullName('Michael Rubél');
    $this->assertSame([
        'fullName'  => 'Michael Rubél',
        'firstName' => 'Michael',
        'lastName'  => 'Rubél',
    ], $valueObject->toArray());

    $valueObject = new FullName('Richard Le Poidevin', 2);
    $this->assertSame([
        'fullName'  => 'Richard Le Poidevin',
        'firstName' => 'Richard',
        'lastName'  => 'Le Poidevin',
    ], $valueObject->toArray());
});

test('full name is stringable', function () {
    $valueObject = new FullName('Name Name');
    $this->assertSame($valueObject->value(), (string) $valueObject);
});

test('full name accepts stringable', function () {
    $valueObject = new FullName(str('Name Name'));
    $this->assertSame('Name Name', $valueObject->value());
});

test('full name fails when passed only first name', function () {
    $this->expectException(ValidationException::class);

    new FullName('Name');
});

test('full name has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new FullName('Michael Rubél');
    $this->assertSame('Michael Rubél', $valueObject->value);
    $valueObject->full_name = 'immutable';
});

test('full name has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new FullName('Michael Rubél');
    $valueObject->__construct(' Michael Rubél ');
});

test('can extend protected methods in email', function () {
    $fullName = new TestFullName('First Second Third Fourth Name', 2);
    $this->assertSame([
        'fullName'  => 'First Second Third Fourth Name',
        'firstName' => 'First',
        'lastName'  => 'Second Third Fourth Name',
    ], $fullName->toArray());
});

class TestFullName extends FullName
{
    public function __construct(string|Stringable $value, protected int $limit = -1)
    {
        $this->value = $value;

        $this->split();
    }

    protected function split(): void
    {
        parent::split();
    }
}
