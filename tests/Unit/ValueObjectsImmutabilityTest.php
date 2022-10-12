<?php

namespace MichaelRubel\ValueObjects\Tests\Feature\ValueObjects;

use Illuminate\Support\Str;
use MichaelRubel\ValueObjects\Collection\Complex\ClassString;
use MichaelRubel\ValueObjects\Collection\Complex\FullName;
use MichaelRubel\ValueObjects\Collection\Complex\TaxNumber;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use MichaelRubel\ValueObjects\Collection\Primitive\Boolean;
use MichaelRubel\ValueObjects\Collection\Primitive\Decimal;
use MichaelRubel\ValueObjects\Collection\Primitive\Integer;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;
use PHP\Math\BigNumber\BigNumber;

test('class string value object is immutable', function () {
    $valueObject = new ClassString('\Exception');
    $this->assertSame('\Exception', $valueObject->string);
    $valueObject->classString = 'immutable';
})->expectException(\InvalidArgumentException::class);

test('full name value object is immutable', function () {
    $valueObject = new FullName('Michael');
    $this->assertSame('Michael', $valueObject->value);
    $valueObject->full_name = 'immutable';
})->expectException(\InvalidArgumentException::class);

test('tax number value object is immutable', function () {
    $valueObject = new TaxNumber('PL0123456789');
    $this->assertSame('0123456789', $valueObject->number);
    $valueObject->tax_number = 'immutable';
})->expectException(\InvalidArgumentException::class);

test('uuid value object is immutable', function () {
    $uuid        = (string) Str::uuid();
    $valueObject = new Uuid($uuid);
    $this->assertSame($uuid, $valueObject->value);
    $valueObject->tax_number = 'immutable';
})->expectException(\InvalidArgumentException::class);

test('boolean value object is immutable', function () {
    $valueObject = new Boolean('1');
    $this->assertTrue($valueObject->value);
    $valueObject->value = '0';
})->expectException(\InvalidArgumentException::class);

test('decimal value object is immutable', function () {
    $valueObject = new Decimal('1.2000');
    $this->assertEquals(new BigNumber('1.20', 2), $valueObject->number);
    $valueObject->number = new BigNumber('1.20');
})->expectException(\InvalidArgumentException::class);

test('integer value object is immutable', function () {
    $valueObject = new Integer(1);
    $this->assertEquals(new BigNumber('1', 0), $valueObject->number);
    $valueObject->number = new BigNumber(1);
})->expectException(\InvalidArgumentException::class);

test('text value object is immutable', function () {
    $valueObject = new Text('Lorem ipsum');
    $this->assertSame('Lorem ipsum', $valueObject->value);
    $valueObject->value = 'test';
})->expectException(\InvalidArgumentException::class);
