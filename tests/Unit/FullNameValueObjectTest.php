<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\FullName;

test('can get first name', function () {
    $name = new FullName('Michael');

    assertSame('Michael', $name->firstName());
});

test('can get last name', function () {
    $name = new FullName('Rubél');

    assertSame('Rubél', $name->lastName());
});

test('can get full name', function () {
    $name = new FullName('Michael Rubél');

    assertSame('Michael Rubél', $name->fullName());
});

test('can get cast to string', function () {
    $name = new FullName('Michael Rubél');

    assertSame('Michael Rubél', (string) $name);
});

test('can sue make method', function () {
    $name = FullName::make('Michael Rubél');

    assertSame('Michael Rubél', $name->fullName());
});

test('can pass nulls and returns empty string', function () {
    $name = new FullName('');
    assertSame('', $name->fullName());

    $name = new FullName(null);
    assertSame('', $name->fullName());

    $name = new FullName(null, null);
    assertSame('', $name->fullName());
});

test('full name value object is macroable', function () {
    FullName::macro('getLength', function () {
        return str($this->fullName())->length();
    });

    $valueObject = FullName::make('Michael');

    assertSame(7, $valueObject->getLength());
});

test('full name value object is conditionable', function () {
    $valueObject = FullName::make('Michael Rubél');

    assertSame('Michael', $valueObject->when(true)->firstName());
    assertSame($valueObject, $valueObject->when(false)->firstName());
});

test('full name value object is tappable', function () {
    $valueObject = FullName::make('Michael Rubél');

    $valueObject->tap(function ($object) use ($valueObject) {
        assertSame($valueObject, $object);
    });
});

test('full name value object is arrayable', function () {
    $valueObject = FullName::make('Michael Rubél');

    assertSame([
        'full_name'  => 'Michael Rubél',
        'first_name' => 'Michael',
        'last_name'  => 'Rubél',
    ], $valueObject->toArray());
});
