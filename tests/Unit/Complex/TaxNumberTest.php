<?php

namespace MichaelRubel\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\TaxNumber;

test('data in tax number is null and country is null', function () {
    $data = new TaxNumber;
    $this->assertEmpty($data->country());
    $this->assertEmpty($data->taxNumber());
});

test('data in tax number is number plus prefix country is null', function () {
    $data = new TaxNumber('PL1234567890');
    $this->assertEquals('PL', $data->country());
    $this->assertEquals('1234567890', $data->taxNumber());
});

test('data in tax number is number plus prefix country is null and prefix lowercase char', function () {
    $data = new TaxNumber('pl1234567890');
    $this->assertEquals('PL', $data->country());
    $this->assertEquals('1234567890', $data->taxNumber());
});

test('data in tax number is number without prefix country is null', function () {
    $data = new TaxNumber('1234567890');
    $this->assertEquals('', $data->country());
    $this->assertEquals('1234567890', $data->taxNumber());
});

test('data in tax number is number plus prefix country is ok', function () {
    $data = new TaxNumber('PL1234567890', 'PL');
    $this->assertEquals('PL', $data->country());
    $this->assertEquals('1234567890', $data->taxNumber());
});

test('data in tax number is number country is added', function () {
    $data = new TaxNumber('1234567890', 'pL');
    $this->assertEquals('PL', $data->country());
    $this->assertEquals('1234567890', $data->taxNumber());
});

test('data in tax number is number country is added another', function () {
    $data = new TaxNumber('pL1234567890', 'aa');
    $this->assertEquals('AA', $data->country());
    $this->assertEquals('PL1234567890', $data->taxNumber());
});

test('data in tax number is number country is added out full number vat', function () {
    $data = new TaxNumber('1234567890', 'pL');
    $this->assertEquals('PL1234567890', $data->fullTaxNumber());
});

test('data in tax number is number country is added and special characters out full number vat', function () {
    $data = new TaxNumber(' pl 123-456.78 90 ', 'pL');
    $this->assertEquals('PL1234567890', $data->fullTaxNumber());
});

test('data in tax number is number country is added another static', function () {
    $data = new TaxNumber('pL006888nHy', 'aZ');
    $this->assertEquals('AZ', $data->country());
    $this->assertEquals('PL006888NHY', $data->taxNumber());
});

test('data in ta number is number country is added another method to string', function () {
    $this->assertEquals('AZPL123ABC456', new TaxNumber('pL123aBc456', 'aZ'));
});

test('short data in tax number is number and country', function () {
    $this->assertEquals('A6', new TaxNumber('6', 'a'));
});

test('tests that are used in the examples in ReadMe', function () {
    $this->assertEquals('PL0123456789', new TaxNumber('pl0123456789'));
    $this->assertEquals('PL0123456789', new TaxNumber('PL0123456789', 'pL'));
    $this->assertEquals('PL0123456789', new TaxNumber('0123456789', 'pL'));
    $this->assertEquals('PLAB0123456789', new TaxNumber('Ab0123456789', 'pL'));
    $this->assertEquals('PL0123456789', new TaxNumber('PL 012-345 67.89'));

    $multi = new TaxNumber('Ab 012-345 67.89', 'uK');
    $this->assertEquals('UKAB0123456789', $multi);
    $this->assertEquals('UKAB0123456789', $multi->fullTaxNumber());
    $this->assertEquals('UK', $multi->country());
    $this->assertEquals('AB0123456789', $multi->taxNumber());
});

test('passed null values to value object', function () {
    $data = new TaxNumber(null, null);
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber(null, null))
        ->fullTaxNumber();
    $this->assertEquals('', $data);

    $data = new TaxNumber(null, null);
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber(null, null))->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed empty values to value object', function () {
    $data = new TaxNumber('', '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber('', ''))
        ->fullTaxNumber();
    $this->assertEquals('', $data);

    $data = new TaxNumber('', '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber('', ''))->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed empty tax number and null country', function () {
    $data = new TaxNumber('', null);
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber('', null))
        ->fullTaxNumber();
    $this->assertEquals('', $data);

    $data = new TaxNumber('', null);
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber('', null))->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed null tax number and empty country', function () {
    $data = new TaxNumber(null, '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber(null, ''))
        ->fullTaxNumber();
    $this->assertEquals('', $data);

    $data = new TaxNumber(null, '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber(null, ''))->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('tax number is makeable', function () {
    $valueObject = TaxNumber::make('PL0123456789');
    $this->assertSame('PL0123456789', $valueObject->value());
});

test('tax number is macroable', function () {
    TaxNumber::macro('getLength', function () {
        return str($this->fullTaxNumber())->length();
    });
    $valueObject = new TaxNumber('PL0123456789');
    $this->assertSame(12, $valueObject->getLength());
});

test('tax number is conditionable', function () {
    $valueObject = new TaxNumber('PL0123456789');
    $this->assertSame('PL', $valueObject->when(true)->country());
    $this->assertSame($valueObject, $valueObject->when(false)->country());
});

test('tax number is arrayable', function () {
    $valueObject = new TaxNumber('PL0123456789');

    $this->assertSame([
        'fullTaxNumber' => 'PL0123456789',
        'taxNumber'     => '0123456789',
        'country'       => 'PL',
    ], $valueObject->toArray());
});

test('tax number is stringable', function () {
    $valueObject = new TaxNumber('PL0123456789');
    $this->assertSame($valueObject->value(), (string) $valueObject);
});
