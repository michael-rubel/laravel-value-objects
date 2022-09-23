<?php

declare(strict_types=1);

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Primitive\Integer;

test('integer can accept integer', function () {
    $valueObject = new Integer(1);
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer(2);
    $this->assertSame(2, $valueObject->value());
});

test('integer can accept string', function () {
    $valueObject = new Integer('1');
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer('1.2');
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer('1.3');
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer('1.7');
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer('1.8');
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer('2');
    $this->assertSame(2, $valueObject->value());
    $valueObject = new Integer('3.1');
    $this->assertSame(3, $valueObject->value());
});

test('integer can accept float', function () {
    $valueObject = new Integer(1.2);
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer(1.3);
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer(1.7);
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer(1.8);
    $this->assertSame(1, $valueObject->value());
    $valueObject = new Integer(2.1);
    $this->assertSame(2, $valueObject->value());
});

test('integer can accept null', function () {
    $valueObject = new Integer(null);
    $this->assertSame(0, $valueObject->value());
});

test('integer is makeable', function () {
    $valueObject = Integer::make(1);
    $this->assertSame(1, $valueObject->value());
});

test('integer is macroable', function () {
    Integer::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = Integer::make(12);
    $this->assertSame(2, $valueObject->getLength());
});

test('integer is conditionable', function () {
    $valueObject = Integer::make(1);
    $this->assertSame(1, $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('integer is arrayable', function () {
    $array = (new Integer(1))->toArray();
    $this->assertSame([1], $array);
});

test('integer is stringable', function () {
    $valueObject = Integer::make(1);
    $this->assertSame('1', (string) $valueObject);
    $valueObject = Integer::make(1.2);
    $this->assertSame('1', (string) $valueObject);
    $valueObject = Integer::make(1.3);
    $this->assertSame('1', (string) $valueObject);
    $valueObject = Integer::make(1.7);
    $this->assertSame('1', (string) $valueObject);
    $valueObject = Integer::make(1.8);
    $this->assertSame('1', (string) $valueObject);
});
