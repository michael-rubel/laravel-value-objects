<?php

namespace MichaelRubel\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\TaxNumber;

test('data in tax number is null and country is null', function () {
    $data = new TaxNumber;
    $this->assertEmpty($data->getCountry());
    $this->assertEmpty($data->getTaxNumber());
});

test('data in tax number is number plus prefix country is null', function () {
    $data = new TaxNumber('PL1234567890');
    $this->assertEquals('PL', $data->getCountry());
    $this->assertEquals('1234567890', $data->getTaxNumber());
});

test('data in tax number is number plus prefix country is null and prefix lowercase char', function () {
    $data = new TaxNumber('pl1234567890');
    $this->assertEquals('PL', $data->getCountry());
    $this->assertEquals('1234567890', $data->getTaxNumber());
});

test('data in tax number is number without prefix country is null', function () {
    $data = new TaxNumber('1234567890');
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('1234567890', $data->getTaxNumber());
});

test('data in tax number is number plus prefix country is ok', function () {
    $data = new TaxNumber('PL1234567890', 'PL');
    $this->assertEquals('PL', $data->getCountry());
    $this->assertEquals('1234567890', $data->getTaxNumber());
});

test('data in tax number is number country is added', function () {
    $data = new TaxNumber('1234567890', 'pL');
    $this->assertEquals('PL', $data->getCountry());
    $this->assertEquals('1234567890', $data->getTaxNumber());
});

test('data in tax number is number country is added another', function () {
    $data = new TaxNumber('pL1234567890', 'aa');
    $this->assertEquals('AA', $data->getCountry());
    $this->assertEquals('PL1234567890', $data->getTaxNumber());
});

test('data in tax number is number country is added out full number vat', function () {
    $data = new TaxNumber('1234567890', 'pL');
    $this->assertEquals('PL1234567890', $data->getFullTaxNumber());
});

test('data in tax number is number country is added and special characters out full number vat', function () {
    $data = new TaxNumber(' pl 123-456.78 90 ', 'pL');
    $this->assertEquals('PL1234567890', $data->getFullTaxNumber());
});

test('data in tax number is number country is added another static', function () {
    $data = TaxNumber::make('pL006888nHy', 'aZ');
    $this->assertEquals('AZ', $data->getCountry());
    $this->assertEquals('PL006888NHY', $data->getTaxNumber());
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
    $this->assertEquals('UKAB0123456789', $multi->getFullTaxNumber());
    $this->assertEquals('UK', $multi->getCountry());
    $this->assertEquals('AB0123456789', $multi->getTaxNumber());
});

test('passed null values to value object', function () {
    $data = new TaxNumber(null, null);
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = (new TaxNumber(null, null))
        ->getFullTaxNumber();
    $this->assertEquals('', $data);

    $data = TaxNumber::make(null, null);
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = TaxNumber::make(null, null)
        ->getFullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed empty values to value object', function () {
    $data = new TaxNumber('', '');
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = (new TaxNumber('', ''))
        ->getFullTaxNumber();
    $this->assertEquals('', $data);

    $data = TaxNumber::make('', '');
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = TaxNumber::make('', '')
        ->getFullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed empty tax number and null country', function () {
    $data = new TaxNumber('', null);
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = (new TaxNumber('', null))
        ->getFullTaxNumber();
    $this->assertEquals('', $data);

    $data = TaxNumber::make('', null);
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = TaxNumber::make('', null)
        ->getFullTaxNumber();
    $this->assertEquals('', $data);
});

test('passed null tax number and empty country', function () {
    $data = new TaxNumber(null, '');
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = (new TaxNumber(null, ''))
        ->getFullTaxNumber();
    $this->assertEquals('', $data);

    $data = TaxNumber::make(null, '');
    $this->assertEquals('', $data->getCountry());
    $this->assertEquals('', $data->getTaxNumber());

    $data = TaxNumber::make(null, '')
        ->getFullTaxNumber();
    $this->assertEquals('', $data);
});

test('tax number value object is macroable', function () {
    TaxNumber::macro('getLength', function () {
        return str($this->getFullTaxNumber())->length();
    });

    $valueObject = TaxNumber::make('PL0123456789');

    assertSame(12, $valueObject->getLength());
});

test('tax number value object is conditionable', function () {
    $valueObject = TaxNumber::make('PL0123456789');

    assertSame('PL', $valueObject->when(true)->getCountry());
    assertSame($valueObject, $valueObject->when(false)->getCountry());
});

test('tax number value object is tappable', function () {
    $valueObject = TaxNumber::make('PL0123456789');

    $valueObject->tap(function ($object) use ($valueObject) {
        assertSame($valueObject, $object);
    });
});

test('tax number value object is arrayable', function () {
    $valueObject = TaxNumber::make('PL0123456789');

    assertSame([
        'full_tax_number' => 'PL0123456789',
        'tax_number'      => '0123456789',
        'country'         => 'PL',
    ], $valueObject->toArray());
});
