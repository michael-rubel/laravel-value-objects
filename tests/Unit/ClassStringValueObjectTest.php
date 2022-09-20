<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\ClassString;
use MichaelRubel\ValueObjects\Tests\TestCase;

test('class string is empty string', function () {
    $classString = new ClassString('');

    assertFalse($classString->classExists());
    assertFalse($classString->interfaceExists());
});

test('can get class string', function () {
    $classString = new ClassString('My\Test\Class');

    assertSame('My\Test\Class', $classString->value());
});

test('class string not instantiable and class and interface are undefined', function () {
    $classString = new ClassString('My\Test\Class\NotInstantiable');

    assertFalse($classString->classExists());
    assertFalse($classString->interfaceExists());
});

test('class string is exists but interface dont', function () {
    $classString = new ClassString(ClassString::class);

    assertTrue($classString->classExists());
    assertFalse($classString->interfaceExists());
});

test('class string is interface & exists but class dont', function () {
    $classString = new ClassString(TestCase::class);

    assertTrue($classString->classExists());
    assertFalse($classString->interfaceExists());
});

test('can cast class string to string', function () {
    $classString = new ClassString(ClassString::class);

    assertSame('MichaelRubel\ValueObjects\Complex\ClassString', (string) $classString);
});

test('class string is null', function () {
    $classString = new ClassString('');
    assertSame('', $classString->value());

    $classString = new ClassString(null);
    assertSame('', $classString->value());

    $classString = new ClassString(null);
    assertSame('', (string) $classString);
});

test('class string value object is macroable', function () {
    ClassString::macro('getLength', function () {
        return str($this->value())->length();
    });

    $valueObject = ClassString::make('TestClass\Testing');

    assertSame(17, $valueObject->getLength());
});

test('class string value object is conditionable', function () {
    $valueObject = ClassString::make(TestCase::class);

    assertTrue($valueObject->when(true)->classExists());
    assertSame($valueObject, $valueObject->when(false)->classExists());
});

test('class string value object is tappable', function () {
    $valueObject = ClassString::make(TestCase::class);

    $valueObject->tap(function ($object) use ($valueObject) {
        assertSame($valueObject, $object);
    });
});
