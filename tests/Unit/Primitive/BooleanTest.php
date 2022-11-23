<?php

declare(strict_types=1);

use MichaelRubel\ValueObjects\Collection\Primitive\Boolean;

test('boolean can accept integer', function () {
    $valueObject = new Boolean(0);
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean(1);
    $this->assertTrue($valueObject->value());
});

test('boolean can accept integer as a string', function () {
    $valueObject = new Boolean('0');
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean('1');
    $this->assertTrue($valueObject->value());
});

test('boolean can accept boolean strings', function () {
    $valueObject = new Boolean('false');
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean('False');
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean('off');
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean('no');
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean('FALSE');
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean('true');
    $this->assertTrue($valueObject->value());
    $valueObject = new Boolean('True');
    $this->assertTrue($valueObject->value());
    $valueObject = new Boolean('TRUE');
    $this->assertTrue($valueObject->value());
    $valueObject = new Boolean('on');
    $this->assertTrue($valueObject->value());
    $valueObject = new Boolean('yes');
    $this->assertTrue($valueObject->value());
});

test('boolean can accept native booleans', function () {
    $valueObject = new Boolean(false);
    $this->assertFalse($valueObject->value());
    $valueObject = new Boolean(true);
    $this->assertTrue($valueObject->value());
});

test('boolean fails when no argument passed', function () {
    $this->expectException(\TypeError::class);

    new Boolean;
});

test('boolean fails when null passed', function () {
    $this->expectException(\TypeError::class);

    (new Boolean(null))->value();
});

test('boolean fails when empty string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    (new Boolean(''))->value();
});

test('boolean fails when any string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    (new Boolean('asd'))->value();
});

test('boolean is makeable', function () {
    $valueObject = Boolean::make(1);
    $this->assertTrue($valueObject->value());
    $valueObject = Boolean::make(0);
    $this->assertFalse($valueObject->value());
    $valueObject = Boolean::make('1');
    $this->assertTrue($valueObject->value());
    $valueObject = Boolean::make('0');
    $this->assertFalse($valueObject->value());
    $valueObject = Boolean::make('true');
    $this->assertTrue($valueObject->value());
    $valueObject = Boolean::make('false');
    $this->assertFalse($valueObject->value());

    $valueObject = Boolean::from(1);
    $this->assertTrue($valueObject->value());
    $valueObject = Boolean::from(0);
    $this->assertFalse($valueObject->value());
    $valueObject = Boolean::from('1');
    $this->assertTrue($valueObject->value());
    $valueObject = Boolean::from('0');
    $this->assertFalse($valueObject->value());
    $valueObject = Boolean::from('true');
    $this->assertTrue($valueObject->value());
    $valueObject = Boolean::from('false');
    $this->assertFalse($valueObject->value());
});

test('boolean is macroable', function () {
    Boolean::macro('getPositiveValues', fn () => $this->trueValues);
    Boolean::macro('getNegativeValues', fn () => $this->falseValues);
    $valueObject = new Boolean(1);
    $this->assertSame([
        '1', 'true', 'True', 'TRUE', 1, true, 'on', 'yes'
    ], $valueObject->getPositiveValues());
    $this->assertSame([
        '0', 'false', 'False', 'FALSE', 0, false, 'off', 'no'
    ], $valueObject->getNegativeValues());
});

test('boolean is conditionable', function () {
    $valueObject = new Boolean('1');
    $this->assertTrue($valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('boolean is arrayable', function () {
    $array = (new Boolean(1))->toArray();
    $this->assertSame([true], $array);
    $array = (new Boolean(0))->toArray();
    $this->assertSame([false], $array);
    $array = (new Boolean('1'))->toArray();
    $this->assertSame([true], $array);
    $array = (new Boolean('0'))->toArray();
    $this->assertSame([false], $array);
    $array = (new Boolean('true'))->toArray();
    $this->assertSame([true], $array);
    $array = (new Boolean('false'))->toArray();
    $this->assertSame([false], $array);
});

test('boolean is stringable', function () {
    $valueObject = new Boolean(1);
    $this->assertSame('true', $valueObject->toString());
    $valueObject = new Boolean(0);
    $this->assertSame('false', (string) $valueObject);
    $valueObject = new Boolean('1');
    $this->assertSame('true', (string) $valueObject);
    $valueObject = new Boolean('0');
    $this->assertSame('false', (string) $valueObject);
    $valueObject = new Boolean('true');
    $this->assertSame('true', (string) $valueObject);
    $valueObject = new Boolean('false');
    $this->assertSame('false', $valueObject->toString());
});

test('boolean has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Boolean('1');
    $this->assertTrue($valueObject->value);
    $valueObject->value = '0';
});

test('boolean has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Boolean('1');
    $valueObject->__construct('false');
});

test('can extend protected methods in boolean', function () {
    $bool = new TestBoolean('true');
    assertTrue($bool->isInTrueValues());
    assertIsBool($bool->value());

    $bool = new TestBoolean('false');
    assertTrue($bool->isInFalseValues());
    assertIsBool($bool->value());
});

class TestBoolean extends Boolean
{
    public function __construct(bool|int|string $value)
    {
        $this->value = $value;
    }

    public function isInTrueValues(): bool
    {
        return parent::isInTrueValues();
    }

    public function isInFalseValues(): bool
    {
        return parent::isInFalseValues();
    }
}
