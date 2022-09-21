<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\FullName;

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

test('can get cast to string', function () {
    $name = new FullName('Michael Rubél');

    $this->assertSame('Michael Rubél', (string) $name);
});

test('can sue make method', function () {
    $name = FullName::make('Michael Rubél');

    $this->assertSame('Michael Rubél', $name->fullName());
});

test('can pass nulls and returns empty string', function () {
    $name = new FullName('');
    $this->assertSame('', $name->fullName());

    $name = new FullName(null);
    $this->assertSame('', $name->fullName());

    $name = new FullName(null, null);
    $this->assertSame('', $name->fullName());
});

test('full name value object is macroable', function () {
    FullName::macro('getLength', function () {
        return str($this->fullName())->length();
    });

    $valueObject = FullName::make('Michael');

    $this->assertSame(7, $valueObject->getLength());
});

test('full name value object is conditionable', function () {
    $valueObject = FullName::make('Michael Rubél');

    $this->assertSame('Michael', $valueObject->when(true)->firstName());
    $this->assertSame($valueObject, $valueObject->when(false)->firstName());
});

test('full name value object is arrayable', function () {
    $valueObject = FullName::make('Michael Rubél');
    $this->assertSame([
        'full_name'  => 'Michael Rubél',
        'first_name' => 'Michael',
        'last_name'  => 'Rubél',
    ], $valueObject->toArray());
});
