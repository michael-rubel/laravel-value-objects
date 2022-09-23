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

test('can get full name next case', function () {
    $name = new FullName('Anna Nowak-Kowalska');

    $this->assertSame('Anna', $name->firstName());
    $this->assertSame('Nowak-Kowalska', $name->lastName());
})->skip('todo: minus case');

test('can get full name with name in between', function () {
    $name = new FullName('Anna Ewa Kowalska');

    $this->assertSame('Anna', $name->firstName());
    $this->assertSame('Kowalska', $name->lastName());
})->skip('todo: name in between case');

test('can get cast to string', function () {
    $name = new FullName('Michael Rubél');

    $this->assertSame('Michael Rubél', (string) $name);
});

test('can pass nulls and returns empty string', function () {
    $name = new FullName('');
    $this->assertSame('', $name->fullName());

    $name = new FullName(null);
    $this->assertSame('', $name->fullName());

    $name = new FullName(null, null);
    $this->assertSame('', $name->fullName());
});

test('full name is makeable', function () {
    $name = FullName::make('Michael Rubél');
    $this->assertSame('Michael Rubél', $name->fullName());
});

test('full name is macroable', function () {
    FullName::macro('getLength', function () {
        return str($this->fullName())->length();
    });

    $valueObject = new FullName('Michael');

    $this->assertSame(7, $valueObject->getLength());
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
