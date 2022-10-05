<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Collection\Complex\FullName;

test('can get first name', function () {
    $name = new FullName('Michael');

    $this->assertSame('Michael', $name->firstName());
});

test('can get last name', function () {
    $name = new FullName('Rubél');

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

test('can get full name space case', function () {
    $name = new FullName('Alicja', 'Bachleda Curuś');

    $this->assertSame('Alicja', $name->firstName());
    $this->assertSame('Bachleda Curuś', $name->lastName());
})->skip('edge case with spaces in last name');

test('can get full name with name in between', function () {
    $name = new FullName('Anna Ewa Kowalska');

    $this->assertSame('Anna', $name->firstName());
    $this->assertSame('Kowalska', $name->lastName());
});

test('can get cast to string', function () {
    $name = new FullName('Michael Rubél');

    $this->assertSame('Michael Rubél', (string) $name);
});

test('cannot pass empty string', function () {
    $this->expectException(\InvalidArgumentException::class);
    $name = new FullName('');
    $this->assertSame('', $name->fullName());
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
});

test('full name is stringable', function () {
    $valueObject = new FullName('Name');
    $this->assertSame($valueObject->value(), (string) $valueObject);
});
