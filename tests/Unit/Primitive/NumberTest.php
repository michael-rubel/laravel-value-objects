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

test('number can cast to float', function () {
    $valueObject = new Number('36000.50');
    $this->assertSame(36000.50, $valueObject->asFloat());
});

test('number as a big number', function () {
    $number = new Number('20000.793', 3);
    $this->assertEquals(new BigNumber('20000.793', 3, false), $number->asBigNumber());
});

test('number can be divided using magic call', function () {
    $number = new Number('20000.793', 4);
    $this->assertSame('10000.3965', $number->divide(2));
});

test('number can be multiplied using magic call', function () {
    $number = new Number('20000.793', 3);
    $this->assertSame('40001.586', $number->multiply(2));
});

test('number strips zeros when the value starts from zero', function ($input, $result) {
    $valueObject = new Number($input);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['0000123.987', '123.98'],
    ['0000123', '123.00'],
]);

test('number can accept string', function ($input, $result) {
    $valueObject = new Number($input);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['1', '1.00'],
    ['1.2', '1.20'],
    ['1.3', '1.30'],
    ['1.7', '1.70'],
    ['1.8', '1.80'],
    ['2', '2.00'],
    ['3.1', '3.10'],
    [' 100,000 ', '100.00'],
    [' 100 000 ,000  ', '100000.00'],
]);

test('number accepts formatted value', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    // Only commas:
    ['1,230,00', 2, '1230.00'],
    ['123,123,123,5555', 3, '123123123.555'],

    // Only dots:
    ['1.230.00', 2, '1230.00'],
    ['123.123.123.555', 2, '123123123.55'],

    // Dot-comma convention:
    ['1.230,00', 2, '1230.00'],
    ['123.123.123,556', 3, '123123123.556'],

    // Comma-dot convention:
    ['1,230.00', 2, '1230.00'],
    ['123,123,123.555', 2, '123123123.55'],

    // Space-dot convention:
    ['1 230.00', 2, '1230.00'],
    ['123 123 123.55', 2, '123123123.55'],

    // Space-comma convention:
    ['1 230,00', 2, '1230.00'],
    ['123 123 123,55', 2, '123123123.55'],

    // Mixed convention:
    ['1 230,', 2, '1230.00'],
    [',00', 2, '0.00'],
    ['.00', 2, '0.00'],
    ['123.123 123,55', 2, '123123123.55'],
    ['123,123.123,55', 2, '123123123.55'],
    ['123	123 123,55', 2, '123123123.55'],
    [' 100 000,00 ', 3, '100000.000'],
    [' 100 000,000 ', 2, '100000.00'],
]);

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

test('number can change decimals as a string input', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['111777999.97', 2, '111777999.97'],
    ['111777999,97', 2, '111777999.97'],
    ['111777999.99999999997', 11, '111777999.99999999997'],
    ['92233720368.547', 3, '92233720368.547'],

    ['7.1', 0, '7'],
    ['7.1', 1, '7.1'],
    ['7.11', 2, '7.11'],
    ['7.99', 3, '7.990'],
    ['70.1', 4, '70.1000'],
    ['71.1', 5, '71.10000'],
    ['17.9', 6, '17.900000'],
    ['11.1', 7, '11.1000000'],
    ['11.7', 8, '11.70000000'],
    ['77.77', 9, '77.770000000'],
    ['777.7', 10, '777.7000000000'],
    ['777.7', 11, '777.70000000000'],
    ['777.77', 12, '777.770000000000'],
    ['777.777', 13, '777.7770000000000'],
    ['7771.777', 14, '7771.77700000000000'],
    ['7771.7771', 15, '7771.777100000000000'],
    ['7771.77711', 16, '7771.7771100000000000'],
    ['7771.777111', 17, '7771.77711100000000000'],
    ['7771.7771119', 18, '7771.777111900000000000'],
    ['7771.77711199', 19, '7771.7771119900000000000'],
    ['777177711191777.99977777777777777777', 20, '777177711191777.99977777777777777777'],
]);

test('number can change decimals as a float input up to 14 characters/digits', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    [111777999.97, 2, '111777999.97'],

    [7.1, 0, '7'],
    [7.1, 1, '7.1'],
    [7.11, 2, '7.11'],
    [7.99, 3, '7.990'],
    [70.1, 4, '70.1000'],
    [71.1, 5, '71.10000'],
    [17.9, 6, '17.900000'],
    [11.1, 7, '11.1000000'],
    [11.7, 8, '11.70000000'],
    [77.77, 9, '77.770000000'],
    [777.7, 10, '777.7000000000'],
    [777.7, 11, '777.70000000000'],
    [777.77, 12, '777.770000000000'],
    [777.777, 13, '777.7770000000000'],
    [7771.777, 14, '7771.77700000000000'],
    [7771.7771, 15, '7771.777100000000000'],
    [7771.77711, 16, '7771.7771100000000000'],
    [7771.777111, 17, '7771.77711100000000000'],
    [7771.7771119, 18, '7771.777111900000000000'],
    [7771.77711199, 19, '7771.7771119900000000000'],
    [3210987654321.0, 2, '3210987654321.00'],
    [290987654321.78, 2, '290987654321.78'],
    [92233720368.987, 2, '92233720368.98'],
    [9223372036.8547, 2, '9223372036.85'],
    [1.999999999999, 12, '1.999999999999'],
    [2.9999999999999, 12, '2.999999999999'],
    [290987654321.78, 3, '290987654321.780'],
    [92233720368.987, 3, '92233720368.987'],
    [9223372036.8547, 3, '9223372036.854'],
    [7771.0777110012, 3, '7771.077'],
    [9876.100077799, 3, '9876.100'],
    [1.543210987671, 3, '1.543'],
    [00002.5432109876712, 3, '2.543'],
    [3.5432109876789, 3, '3.543'],
    [11.543210987671, 3, '11.543'],
    [10987654321.789, 3, '10987654321.789'],
    [3210987654321.7, 3, '3210987654321.700'],
    [44210987654321.0, 3, '44210987654321.000'],
    [92233720368.547, 3, '92233720368.547'],
]);

test('numeric integer in float form input up to 14 characters/digitss', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    [1.0, 3, '1.000'],
    [2.0000, 3, '2.000'],
    [1234567890.0000, 3, '1234567890.000'],
    [12345678901234.0000, 3, '12345678901234.000'],
]);

test('no conversion of decimal numbers as float input above 14 characters/digits', function ($number) {
    try {
        new Number($number, 20);
        $this->assertFalse(true);
    } catch (LengthException $e) {
        $this->assertSame(0, $e->getCode());
        $this->assertSame('Float precision loss detected.', $e->getMessage());
    }
})->with([
    11.5432109876731,
    6667777.1234567890123456789,
    5556666.2345678901234567891,
    4445555.3456789012345678912,
    3334444.4567890123456789123,
    2223333.5678901234567891234,
    1112222.6789012345678912345,
    9991111.7890123456789123456,
    8880000.8901234567891234567,
    8889999.9012345678912345678,
    7778888.0123456789123456789,
    9553543210987654321.77711199,
    777177711191777.99977777777777777777,
]);

test('number can handle huge numbers', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['111777999.97', 2, '111777999.97'],
    ['111777999,97', 2, '111777999.97'],
    ['111777999.99999999997', 11, '111777999.99999999997'],
    ['92233720368.547', 3, '92233720368.547'],
    ['9876543210111777999.9087', 2, '9876543210111777999.90'],
    ['98765432101117779990000.9087', 1, '98765432101117779990000.9'],
]);

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
    $this->assertEquals(new BigNumber('1.20', 2, false), $valueObject->bigNumber);
    $valueObject->bigNumber = new BigNumber('1.20');
});

test('number has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Number('1.2000');
    $valueObject->__construct('1.5000');
});

test('big number is immutable', function () {
    Number::macro('isImmutable', function () {
        return ! $this->bigNumber->isMutable();
    });

    $number = new Number('1.2000');
    $this->assertTrue($number->isImmutable());
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
    $number = new TestNumber(1230.12);
    $this->assertSame('1230.12', $number->value());
});

test('number can accept negative integer', function () {
    $valueObject = new Number(-1);
    $this->assertSame('-1.00', $valueObject->value());
    $valueObject = new Number(-2);
    $this->assertSame('-2.00', $valueObject->value());
});

test('number can cast negative value to integer', function () {
    $valueObject = new Number('-100');
    $this->assertSame(-100, $valueObject->asInteger());
});

test('number can cast negative value to float', function () {
    $valueObject = new Number('-36000.50');
    $this->assertSame(-36000.50, $valueObject->asFloat());
});

test('negative number as a big number', function () {
    $number = new Number('-20000.793', 3);
    $this->assertEquals(new BigNumber('-20000.793', 3, false), $number->asBigNumber());
});

test('negative number can be divided using magic call', function () {
    $number = new Number('-20000.793', 4);
    $this->assertSame('-10000.3965', $number->divide(2));
});

test('negative number can be multiplied using magic call', function () {
    $number = new Number('-20000.793', 3);
    $this->assertSame('-40001.586', $number->multiply(2));
});

test('negative number strips zeros when the value starts from zero', function ($input, $result) {
    $valueObject = new Number($input);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['-0000123.987', '-123.98'],
    ['-0000123', '-123.00'],
]);

test('negative number accepts formatted value', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['-1,230,00', 2, '-1230.00'],
    ['-123.123.123,556', 3, '-123123123.556'],
    ['-1 230,00', 2, '-1230.00'],
    ['-777.7', 3, '-777.700'],
]);

test('negative number fails when invalid text provided', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Number('-asd');
});

test('negative number fails when empty string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Number('-');
});

test('negative number can change decimals as a string input', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['-111777999.97', 2, '-111777999.97'],
    ['-111777999,97', 2, '-111777999.97'],
    ['-7.99', 3, '-7.990'],
    ['-71.1', 5, '-71.10000'],
]);

test('negative number can handle huge numbers', function ($input, $scale, $result) {
    $valueObject = new Number($input, $scale);
    $this->assertSame($result, $valueObject->value());
})->with([
    ['-9876543210111777999.9087', 2, '-9876543210111777999.90'],
    ['-98765432101117779990000.9087', 1, '-98765432101117779990000.9'],
]);

class TestNumber extends Number
{
    public function __construct(int|string|float $number, protected int $scale = 2)
    {
        parent::isPrecise((float) $number);

        $this->bigNumber = new BigNumber($this->sanitize($number), $this->scale);
    }
}
