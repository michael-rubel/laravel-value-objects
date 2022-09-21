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
    $data = TaxNumber::make('pL006888nHy', 'aZ');
    $this->assertEquals('AZ', $data->country());
    $this->assertEquals('PL006888NHY', $data->taxNumber());
});

test('data in ta number is number country is added another method to string', function () {
    $this->assertEquals('AZPL123ABC456', TaxNumber::make('pL123aBc456', 'aZ'));
});

test('short data in tax number is number and country', function () {
    $this->assertEquals('A6', TaxNumber::make('6', 'a'));
});

test('tests that are used in the examples in ReadMe', function () {
    $this->assertEquals('PL0123456789', TaxNumber::make('pl0123456789'));
    $this->assertEquals('PL0123456789', TaxNumber::make('PL0123456789', 'pL'));
    $this->assertEquals('PL0123456789', TaxNumber::make('0123456789', 'pL'));
    $this->assertEquals('PLAB0123456789', TaxNumber::make('Ab0123456789', 'pL'));
    $this->assertEquals('PL0123456789', TaxNumber::make('PL 012-345 67.89'));

    $multi = TaxNumber::make('Ab 012-345 67.89', 'uK');
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

    $data = TaxNumber::make(null, null);
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = TaxNumber::make(null, null)
        ->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed empty values to value object', function () {
    $data = new TaxNumber('', '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber('', ''))
        ->fullTaxNumber();
    $this->assertEquals('', $data);

    $data = TaxNumber::make('', '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = TaxNumber::make('', '')
        ->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed empty tax number and null country', function () {
    $data = new TaxNumber('', null);
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber('', null))
        ->fullTaxNumber();
    $this->assertEquals('', $data);

    $data = TaxNumber::make('', null);
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = TaxNumber::make('', null)
        ->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed null tax number and empty country', function () {
    $data = new TaxNumber(null, '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = (new TaxNumber(null, ''))
        ->fullTaxNumber();
    $this->assertEquals('', $data);

    $data = TaxNumber::make(null, '');
    $this->assertEquals('', $data->country());
    $this->assertEquals('', $data->taxNumber());

    $data = TaxNumber::make(null, '')
        ->fullTaxNumber();
    $this->assertEquals('', $data);
});

test('tax number value object is macroable', function () {
    TaxNumber::macro('getLength', function () {
        return str($this->fullTaxNumber())->length();
    });
    $valueObject = TaxNumber::make('PL0123456789');
    $this->assertSame(12, $valueObject->getLength());
});

test('tax number value object is conditionable', function () {
    $valueObject = TaxNumber::make('PL0123456789');
    $this->assertSame('PL', $valueObject->when(true)->country());
    $this->assertSame($valueObject, $valueObject->when(false)->country());
});

test('tax number value object is arrayable', function () {
    $valueObject = TaxNumber::make('PL0123456789');

    $this->assertSame([
        'full_tax_number' => 'PL0123456789',
        'tax_number'      => '0123456789',
        'country'         => 'PL',
    ], $valueObject->toArray());
});
