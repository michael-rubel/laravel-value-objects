<?php

declare(strict_types=1);

use MichaelRubel\ValueObjects\Collection\Primitive\Number;
use PHP\Math\BigNumber\BigNumber;

test('number can accept integer', function () {
    $valueObject = new Number(1);
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = new Number(2);
    $this->assertSame('2.00', $valueObject->value());
});

test('number can cast to integer', function () {
    $valueObject = new Number('100');
    $this->assertSame(100, $valueObject->asInteger());
});

test('number can accept string', function () {
    $valueObject = new Number('1');
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = new Number('1.2');
    $this->assertSame('1.20', $valueObject->value());
    $valueObject = new Number('1.3');
    $this->assertSame('1.30', $valueObject->value());
    $valueObject = new Number('1.7');
    $this->assertSame('1.70', $valueObject->value());
    $valueObject = new Number('1.8');
    $this->assertSame('1.80', $valueObject->value());
    $valueObject = new Number('2');
    $this->assertSame('2.00', $valueObject->value());
    $valueObject = new Number('3.1');
    $this->assertSame('3.10', $valueObject->value());
    $valueObject = new Number(' 100,000 ');
    $this->assertSame('100.00', $valueObject->value());
    $valueObject = new Number(' 100 000,000 ', 3);
    $this->assertSame('100000.000', $valueObject->value());
});

test('number accepts formatted value', function () {
    // Only commas:
    $valueObject = new Number('1,230,00');
    assertSame('1230.00', $valueObject->value());
    $valueObject = new Number('123,123,123,5555', scale: 3);
    assertSame('123123123.555', $valueObject->value());

    // Only dots:
    $valueObject = new Number('1.230.00');
    assertSame('1230.00', $valueObject->value());
    $valueObject = new Number('123.123.123.555');
    assertSame('123123123.55', $valueObject->value());

    // Dot-comma convention:
    $valueObject = new Number('1.230,00');
    assertSame('1230.00', $valueObject->value());
    $valueObject = new Number('123.123.123,556', scale: 3);
    assertSame('123123123.556', $valueObject->value());

    // Comma-dot convention:
    $valueObject = new Number('1,230.00');
    assertSame('1230.00', $valueObject->value());
    $valueObject = new Number('123,123,123.555');
    assertSame('123123123.55', $valueObject->value());

    // Space-dot convention:
    $valueObject = new Number('1 230.00');
    assertSame('1230.00', $valueObject->value());
    $valueObject = new Number('123 123 123.55');
    assertSame('123123123.55', $valueObject->value());

    // Space-comma convention:
    $valueObject = new Number('1 230,00');
    assertSame('1230.00', $valueObject->value());
    $valueObject = new Number('123 123 123,55');
    assertSame('123123123.55', $valueObject->value());

    // Mixed convention:
    $valueObject = new Number('1 230,');
    assertSame('1230.00', $valueObject->value());
    $valueObject = new Number(',00');
    assertSame('0.00', $valueObject->value());
    $valueObject = new Number('.00');
    assertSame('0.00', $valueObject->value());
    $valueObject = new Number('123.123 123,55');
    assertSame('123123123.55', $valueObject->value());
    $valueObject = new Number('123,123.123,55');
    assertSame('123123123.55', $valueObject->value());
    $valueObject = new Number('123	123 123,55');
    assertSame('123123123.55', $valueObject->value());
});

test('number fails when no argument passed', function () {
    $this->expectException(\TypeError::class);

    new Number;
});

test('number fails when text provided', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Number('asd');
});

test('number fails when empty string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Number('');
});

test('number fails when null passed', function () {
    $this->expectException(\TypeError::class);

    new Number(null);
});

test('number can change decimals', function () {
    $valueObject = new Number('111777999.97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Number('111777999,97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Number('111777999.99999999997', 11);
    $this->assertSame('111777999.99999999997', $valueObject->value());
    $valueObject = new Number('92233720368.547', 3);
    $this->assertSame('92233720368.547', $valueObject->value());

    $valueObject = new Number('7.1', 0);
    $this->assertSame('7', $valueObject->value());
    $valueObject = new Number('7.1', 1);
    $this->assertSame('7.1', $valueObject->value());
    $valueObject = new Number('7.11', 2);
    $this->assertSame('7.11', $valueObject->value());
    $valueObject = new Number('7.99', 3);
    $this->assertSame('7.990', $valueObject->value());
    $valueObject = new Number('70.1', 4);
    $this->assertSame('70.1000', $valueObject->value());
    $valueObject = new Number('71.1', 5);
    $this->assertSame('71.10000', $valueObject->value());
    $valueObject = new Number('17.9', 6);
    $this->assertSame('17.900000', $valueObject->value());
    $valueObject = new Number('11.1', 7);
    $this->assertSame('11.1000000', $valueObject->value());
    $valueObject = new Number('11.7', 8);
    $this->assertSame('11.70000000', $valueObject->value());
    $valueObject = new Number('77.77', 9);
    $this->assertSame('77.770000000', $valueObject->value());
    $valueObject = new Number('777.7', 10);
    $this->assertSame('777.7000000000', $valueObject->value());
    $valueObject = new Number('777.7', 11);
    $this->assertSame('777.70000000000', $valueObject->value());
    $valueObject = new Number('777.77', 12);
    $this->assertSame('777.770000000000', $valueObject->value());
    $valueObject = new Number('777.777', 13);
    $this->assertSame('777.7770000000000', $valueObject->value());
    $valueObject = new Number('7771.777', 14);
    $this->assertSame('7771.77700000000000', $valueObject->value());
    $valueObject = new Number('7771.7771', 15);
    $this->assertSame('7771.777100000000000', $valueObject->value());
    $valueObject = new Number('7771.77711', 16);
    $this->assertSame('7771.7771100000000000', $valueObject->value());
    $valueObject = new Number('7771.777111', 17);
    $this->assertSame('7771.77711100000000000', $valueObject->value());
    $valueObject = new Number('7771.7771119', 18);
    $this->assertSame('7771.777111900000000000', $valueObject->value());
    $valueObject = new Number('7771.77711199', 19);
    $this->assertSame('7771.7771119900000000000', $valueObject->value());
    $valueObject = new Number('777177711191777.99977777777777777777', 20);
    $this->assertSame('777177711191777.99977777777777777777', $valueObject->value());
    $valueObject = new Number('777177711191777.99977777777777777777', 20);
    $this->assertSame('777177711191777.99977777777777777777', $valueObject->value());
});

test('number can handle huge numbers', function () {
    $valueObject = new Number('111777999.97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Number('111777999,97');
    $this->assertSame('111777999.97', $valueObject->value());
    $valueObject = new Number('111777999.99999999997', 11);
    $this->assertSame('111777999.99999999997', $valueObject->value());
    $valueObject = new Number('92233720368.547', 3);
    $this->assertSame('92233720368.547', $valueObject->value());
});

test('number is makeable', function () {
    $valueObject = Number::make('1');
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = Number::make('1.1');
    $this->assertSame('1.10', $valueObject->value());
    $valueObject = Number::make('1');
    $this->assertSame('1.00', $valueObject->value());

    $valueObject = Number::from('1');
    $this->assertSame('1.00', $valueObject->value());
    $valueObject = Number::from('1.1');
    $this->assertSame('1.10', $valueObject->value());
    $valueObject = Number::from('1');
    $this->assertSame('1.00', $valueObject->value());
});

test('number is macroable', function () {
    Number::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = new Number('12.3');
    $this->assertSame(5, $valueObject->getLength());
});

test('number is conditionable', function () {
    $valueObject = new Number('1');
    $this->assertSame('1.00', $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('number is arrayable', function () {
    $array = (new Number('1'))->toArray();
    $this->assertSame(['1.00'], $array);
});

test('number is stringable', function () {
    $valueObject = new Number('1');
    $this->assertSame('1.00', (string) $valueObject);
    $valueObject = new Number('1.2');
    $this->assertSame('1.20', (string) $valueObject);
    $valueObject = new Number('1.3');
    $this->assertSame('1.30', (string) $valueObject);
    $valueObject = new Number('1.7');
    $this->assertSame('1.70', (string) $valueObject);
    $valueObject = new Number('1.8');
    $this->assertSame('1.80', (string) $valueObject);
    $valueObject = new Number('1230.00');
    $this->assertSame('1230.00', $valueObject->toString());
});

test('number has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Number('1.2000');
    $this->assertEquals(new BigNumber('1.20', 2), $valueObject->bigNumber);
    $valueObject->bigNumber = new BigNumber('1.20');
});

test('number has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Number('1.2000');
    $valueObject->__construct('1.5000');
});

test('number uses sanitizes numbers trait', function () {
    $this->assertTrue(
        in_array('MichaelRubel\ValueObjects\Concerns\SanitizesNumbers',
            class_uses_recursive(Number::class)
        )
    );
});

test('can extend protected methods in number', function () {
    $number = new TestNumber('1 230,00');
    $this->assertSame('1230.00', $number->value());
});

class TestNumber extends Number
{
    public function __construct(int|string $number, protected int $scale = 2)
    {
        $this->bigNumber = new BigNumber($this->sanitize($number), $this->scale);
    }

    protected function sanitize(int|string|null $number): string
    {
        return parent::sanitize($number);
    }
}
