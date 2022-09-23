<?php

declare(strict_types=1);

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Primitive\Double;

test('double can accept integer', function () {
    $valueObject = new Double(1);
    $this->assertSame(1.0, $valueObject->value());
    $valueObject = new Double(2);
    $this->assertSame(2.0, $valueObject->value());
});

test('double can accept string', function () {
    $valueObject = new Double('1');
    $this->assertSame(1.0, $valueObject->value());
    $valueObject = new Double('1.2');
    $this->assertSame(1.2, $valueObject->value());
    $valueObject = new Double('1.3');
    $this->assertSame(1.3, $valueObject->value());
    $valueObject = new Double('1.7');
    $this->assertSame(1.7, $valueObject->value());
    $valueObject = new Double('1.8');
    $this->assertSame(1.8, $valueObject->value());
    $valueObject = new Double('2');
    $this->assertSame(2.0, $valueObject->value());
    $valueObject = new Double('3.1');
    $this->assertSame(3.1, $valueObject->value());
});

test('double can accept float', function () {
    $valueObject = new Double(1.2);
    $this->assertSame(1.2, $valueObject->value());
    $valueObject = new Double(1.3);
    $this->assertSame(1.3, $valueObject->value());
    $valueObject = new Double(1.7);
    $this->assertSame(1.7, $valueObject->value());
    $valueObject = new Double(1.8);
    $this->assertSame(1.8, $valueObject->value());
    $valueObject = new Double(2.1);
    $this->assertSame(2.1, $valueObject->value());
});

test('double can accept null', function () {
    $valueObject = new Double(null);
    $this->assertSame(0.0, $valueObject->value());
});

test('integer is makeable', function () {
    $valueObject = Double::make(1);
    $this->assertSame(1.0, $valueObject->value());
    $valueObject = Double::make(1.1);
    $this->assertSame(1.1, $valueObject->value());
    $valueObject = Double::make('1');
    $this->assertSame(1.0, $valueObject->value());
    $valueObject = Double::make(null);
    $this->assertSame(0.0, $valueObject->value());
});

test('integer is macroable', function () {
    Double::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = new Double(12.3);
    $this->assertSame(4, $valueObject->getLength());
});

test('integer is conditionable', function () {
    $valueObject = new Double('1');
    $this->assertSame(1.0, $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('integer is arrayable', function () {
    $array = (new Double(1))->toArray();
    $this->assertSame([1.0], $array);
});

test('integer is stringable', function () {
    $valueObject = new Double(1);
    $this->assertSame('1', (string) $valueObject);
    $valueObject = new Double(1.2);
    $this->assertSame('1.2', (string) $valueObject);
    $valueObject = new Double(1.3);
    $this->assertSame('1.3', (string) $valueObject);
    $valueObject = new Double(1.7);
    $this->assertSame('1.7', (string) $valueObject);
    $valueObject = new Double(1.8);
    $this->assertSame('1.8', (string) $valueObject);
});
