<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Collection\Primitive\Integer;

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

test('decimal fails when no argument passed', function () {
    $this->expectException(\TypeError::class);

    new Integer;
});

test('integer fails when text provided', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Integer('asd');
});

test('integer fails when empty string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Integer('');
});

test('integer fails when null passed', function () {
    $this->expectException(\TypeError::class);

    new Integer(null);
});

test('integer can handle huge numbers', function () {
    $valueObject = new Integer(9223372036854775807);
    $this->assertSame(9223372036854775807, $valueObject->value());
    $valueObject = new Integer('9223372036854775807');
    $this->assertSame(9223372036854775807, $valueObject->value());
    $valueObject = new Integer(-9223372036854775);
    $this->assertSame(-9223372036854775, $valueObject->value());
    $valueObject = new Integer('-9223372036854775');
    $this->assertSame(-9223372036854775, $valueObject->value());

    $valueObject = new Integer('111777999.99997');
    $this->assertSame(111777999, $valueObject->value());
    $valueObject = new Integer('111777999.99999999997');
    $this->assertSame(111777999, $valueObject->value());
    $valueObject = new Integer('111777999,99999999997');
    $this->assertSame(111777999, $valueObject->value());

    $valueObject = new Integer('9223372036854775807.9223372036854775807');
    $this->assertSame(9223372036854775807, $valueObject->value());
    $valueObject = new Integer('9223372036854775807,9223372036854775807');
    $this->assertSame(9223372036854775807, $valueObject->value());
});

test('integer is makeable', function () {
    $valueObject = Integer::make(1);
    $this->assertSame(1, $valueObject->value());
    $valueObject = Integer::make('1.1');
    $this->assertSame(1, $valueObject->value());
    $valueObject = Integer::make('1');
    $this->assertSame(1, $valueObject->value());

    $valueObject = Integer::from(1);
    $this->assertSame(1, $valueObject->value());
    $valueObject = Integer::from('1.1');
    $this->assertSame(1, $valueObject->value());
    $valueObject = Integer::from('1');
    $this->assertSame(1, $valueObject->value());
});

test('integer is macroable', function () {
    Integer::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = new Integer(12);
    $this->assertSame(2, $valueObject->getLength());
});

test('integer is conditionable', function () {
    $valueObject = new Integer('1');
    $this->assertSame(1, $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('integer is arrayable', function () {
    $array = (new Integer(1))->toArray();
    $this->assertSame([1], $array);
});

test('integer is stringable', function () {
    $valueObject = new Integer(1);
    $this->assertSame('1', (string) $valueObject);
    $valueObject = new Integer('1.2');
    $this->assertSame('1', (string) $valueObject);
    $valueObject = new Integer('1.3');
    $this->assertSame('1', (string) $valueObject);
    $valueObject = new Integer('1.7');
    $this->assertSame('1', (string) $valueObject);
    $valueObject = new Integer('1.8');
    $this->assertSame('1', (string) $valueObject);
});
