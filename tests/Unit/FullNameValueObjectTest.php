<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;


use MichaelRubel\ValueObjects\Complex\FullName;

test('can get first name', function () {
    $name = new FullName('Michael');

    assertSame('Michael', $name->getFirstName());
});

test('can get last name', function () {
    $name = new FullName(last_name: 'Rubél');

    assertSame('Rubél', $name->getLastName());
});

test('can get full name', function () {
    $name = new FullName('Michael', 'Rubél');

    assertSame('Michael Rubél', $name->getFullName());
});

test('can get cast to string', function () {
    $name = new FullName('Michael', 'Rubél');

    assertSame('Michael Rubél', (string) $name);
});

test('can pass only last name and get through full name', function () {
    $name = new FullName(last_name: 'Rubél');

    assertSame('Rubél', $name->getFullName());
});

test('can pass only first name and get through full name', function () {
    $name = new FullName(first_name: 'Michael');

    assertSame('Michael', $name->getFullName());
});

test('can sue make method', function () {
    $name = FullName::make('Michael Rubél');

    assertSame('Michael Rubél', $name->getFullName());
});

test('can pass nulls and returns empty string', function () {
    $name = new FullName();
    assertSame('', $name->getFullName());

    $name = new FullName(null);
    assertSame('', $name->getFullName());

    $name = new FullName(null, null);
    assertSame('', $name->getFullName());
});