<?php

declare(strict_types=1);

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Collection\Primitive\Decimal;

test('decimal can accept integer', function () {
    $valueObject = new Decimal(1);
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = new Decimal(2);
    $this->assertSame('2.00', $valueObject->value());
});

test('decimal can accept float', function () {
    $valueObject = new Decimal(1.2);
    $this->assertSame('1.20', $valueObject->value());
    $valueObject = new Decimal(1.3);
    $this->assertSame('1.30', $valueObject->value());
    $valueObject = new Decimal(1.7);
    $this->assertSame('1.70', $valueObject->value());
    $valueObject = new Decimal(1.8);
    $this->assertSame('1.80', $valueObject->value());
    $valueObject = new Decimal(2.1);
    $this->assertSame('2.10', $valueObject->value());
});

test('decimal can accept string', function () {
    $valueObject = new Decimal('1');
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = new Decimal('1.2');
    $this->assertSame('1.20', $valueObject->value());
    $valueObject = new Decimal('1.3');
    $this->assertSame('1.30', $valueObject->value());
    $valueObject = new Decimal('1.7');
    $this->assertSame('1.70', $valueObject->value());
    $valueObject = new Decimal('1.8');
    $this->assertSame('1.80', $valueObject->value());
    $valueObject = new Decimal('2');
    $this->assertSame('2.00', $valueObject->value());
    $valueObject = new Decimal('3.1');
    $this->assertSame('3.10', $valueObject->value());
    $valueObject = new Decimal(' 100,000 ');
    $this->assertSame('100.00', $valueObject->value());
    $valueObject = new Decimal(' 100 000,000 ', 3);
    $this->assertSame('100000.000', $valueObject->value());
});

test('decimal fails when text provided', function () {
    new Decimal('asd');
})->expectException(\InvalidArgumentException::class);

test('decimal fails when empty string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Decimal('');
})->skip('to discuss');

test('decimal can accept null', function () {
    $valueObject = new Decimal(null);
    $this->assertSame('0.00', $valueObject->value());
})->skip('to discuss');

test('decimal can change decimals', function () {
    $valueObject = new Decimal('111777999.97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Decimal('111777999,97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Decimal('111777999.99999999997', 11);
    $this->assertSame('111777999.99999999997', $valueObject->value());
    $valueObject = new Decimal('92233720368.547', 3);
    $this->assertSame('92233720368.547', $valueObject->value());

    $valueObject = new Decimal('7.1', 0);
    $this->assertSame('7', $valueObject->value());
    $valueObject = new Decimal('7.1', 1);
    $this->assertSame('7.1', $valueObject->value());
    $valueObject = new Decimal('7.11', 2);
    $this->assertSame('7.11', $valueObject->value());
    $valueObject = new Decimal('7.99', 3);
    $this->assertSame('7.990', $valueObject->value());
    $valueObject = new Decimal('70.1', 4);
    $this->assertSame('70.1000', $valueObject->value());
    $valueObject = new Decimal('71.1', 5);
    $this->assertSame('71.10000', $valueObject->value());
    $valueObject = new Decimal('17.9', 6);
    $this->assertSame('17.900000', $valueObject->value());
    $valueObject = new Decimal('11.1', 7);
    $this->assertSame('11.1000000', $valueObject->value());
    $valueObject = new Decimal('11.7', 8);
    $this->assertSame('11.70000000', $valueObject->value());
    $valueObject = new Decimal('77.77', 9);
    $this->assertSame('77.770000000', $valueObject->value());
    $valueObject = new Decimal('777.7', 10);
    $this->assertSame('777.7000000000', $valueObject->value());
    $valueObject = new Decimal('777.7', 11);
    $this->assertSame('777.70000000000', $valueObject->value());
    $valueObject = new Decimal('777.77', 12);
    $this->assertSame('777.770000000000', $valueObject->value());
    $valueObject = new Decimal('777.777', 13);
    $this->assertSame('777.7770000000000', $valueObject->value());
    $valueObject = new Decimal('7771.777', 14);
    $this->assertSame('7771.77700000000000', $valueObject->value());
    $valueObject = new Decimal('7771.7771', 15);
    $this->assertSame('7771.777100000000000', $valueObject->value());
    $valueObject = new Decimal('7771.77711', 16);
    $this->assertSame('7771.7771100000000000', $valueObject->value());
    $valueObject = new Decimal('7771.777111', 17);
    $this->assertSame('7771.77711100000000000', $valueObject->value());
    $valueObject = new Decimal('7771.7771119', 18);
    $this->assertSame('7771.777111900000000000', $valueObject->value());
    $valueObject = new Decimal('7771.77711199', 19);
    $this->assertSame('7771.7771119900000000000', $valueObject->value());
    $valueObject = new Decimal('777177711191777.99977777777777777777', 20);
    $this->assertSame('777177711191777.99977777777777777777', $valueObject->value());
    $valueObject = new Decimal('777177711191777.99977777777777777777', 20);
    $this->assertSame('777177711191777.99977777777777777777', $valueObject->value());
});

test('decimal can handle huge numbers', function () {
    $valueObject = new Decimal('111777999.97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Decimal('111777999,97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Decimal('111777999.99999999997', 11);
    $this->assertSame('111777999.99999999997', $valueObject->value());
    $valueObject = new Decimal('92233720368.547', 3);
    $this->assertSame('92233720368.547', $valueObject->value());
});

test('integer is makeable', function () {
    $valueObject = Decimal::make('1');
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = Decimal::make('1.1');
    $this->assertSame('1.10', $valueObject->value());
    $valueObject = Decimal::make('1');
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = Decimal::make(null);
    $this->assertSame('0.00', $valueObject->value());
});

test('integer is macroable', function () {
    Decimal::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = new Decimal('12.3');
    $this->assertSame(5, $valueObject->getLength());
});

test('integer is conditionable', function () {
    $valueObject = new Decimal('1');
    $this->assertSame('1.00', $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('integer is arrayable', function () {
    $array = (new Decimal('1'))->toArray();
    $this->assertSame(['1.00'], $array);
});

test('integer is stringable', function () {
    $valueObject = new Decimal('1');
    $this->assertSame('1.00', (string) $valueObject);
    $valueObject = new Decimal('1.2');
    $this->assertSame('1.20', (string) $valueObject);
    $valueObject = new Decimal('1.3');
    $this->assertSame('1.30', (string) $valueObject);
    $valueObject = new Decimal('1.7');
    $this->assertSame('1.70', (string) $valueObject);
    $valueObject = new Decimal('1.8');
    $this->assertSame('1.80', (string) $valueObject);
});
