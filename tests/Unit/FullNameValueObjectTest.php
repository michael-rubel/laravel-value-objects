<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\FullName;

test('can get first name', function () {
    $name = new FullName('Michael');

    assertSame('Michael', $name->getFirstName());
});

test('can get last name', function () {
    $name = new FullName('Rubél');

    assertSame('Rubél', $name->getLastName());
});

test('can get full name', function () {
    $name = new FullName('Michael Rubél');

    assertSame('Michael Rubél', $name->getFullName());
});

test('can get cast to string', function () {
    $name = new FullName('Michael Rubél');

    assertSame('Michael Rubél', (string) $name);
});

test('can sue make method', function () {
    $name = FullName::make('Michael Rubél');

    assertSame('Michael Rubél', $name->getFullName());
});

test('can pass nulls and returns empty string', function () {
    $name = new FullName('');
    assertSame('', $name->getFullName());

    $name = new FullName(null);
    assertSame('', $name->getFullName());

    $name = new FullName(null, null);
    assertSame('', $name->getFullName());
});

test('tax number value object is conditionable', function () {
    $valueObject = FullName::make('Michael Rubél');

    assertSame('Michael', $valueObject->when(true)->getFirstName());
    assertSame($valueObject, $valueObject->when(false)->getFirstName());
});

test('tax number value object is tappable', function () {
    $valueObject = FullName::make('Michael Rubél');

    $valueObject->tap(function ($object) use ($valueObject) {
        assertSame($valueObject, $object);
    });
});

test('tax number value object is arrayable', function () {
    $valueObject = FullName::make('Michael Rubél');

    assertSame([
        'full_name'  => 'Michael Rubél',
        'first_name' => 'Michael',
        'last_name'  => 'Rubél',
    ], $valueObject->toArray());
});
