<?php

declare(strict_types=1);

use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Complex\TaxNumber;

test('tax number cannot be null', function () {
    $this->expectException(\TypeError::class);

    new TaxNumber(null);
});

test('data in tax number is number plus prefix country is null', function () {
    $data = new TaxNumber('PL1234567890');
    $this->assertEquals('PL', $data->prefix());
    $this->assertEquals('PL', $data->country());
    $this->assertEquals('1234567890', $data->taxNumber());
});

test('data in tax number is number plus prefix country is null and prefix lowercase char', function () {
    $data = new TaxNumber('pl1234567890');
    $this->assertEquals('PL', $data->prefix());
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
    $this->assertEquals('PL', $data->prefix());
    $this->assertEquals('PL', $data->country());
    $this->assertEquals('1234567890', $data->taxNumber());
});

test('data in tax number is number country is added', function () {
    $data = new TaxNumber('1234567890', 'pL');
    $this->assertEquals('PL', $data->prefix());
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
    $data = new TaxNumber('AB0123456789', null);
    $this->assertEquals('AB', $data->country());
    $this->assertEquals('0123456789', $data->taxNumber());

    $data = (new TaxNumber('AB0123456789', null))
        ->fullTaxNumber();
    $this->assertEquals('AB0123456789', $data);

    $data = new TaxNumber('AB0123456789', null);
    $this->assertEquals('AB', $data->country());
    $this->assertEquals('0123456789', $data->taxNumber());

    $data = (new TaxNumber('AB0123456789', null))->fullTaxNumber();
    $this->assertEquals('AB0123456789', $data);
});

test('passed empty values to value object', function () {
    $data = new TaxNumber('AB0123456789', '');
    $this->assertEquals('AB', $data->country());
    $this->assertEquals('0123456789', $data->taxNumber());

    $data = (new TaxNumber('AB0123456789', ''))
        ->fullTaxNumber();
    $this->assertEquals('AB0123456789', $data);

    $data = new TaxNumber('AB0123456789', '');
    $this->assertEquals('AB', $data->country());
    $this->assertEquals('0123456789', $data->taxNumber());

    $data = (new TaxNumber('AB0123456789', ''))->fullTaxNumber();
    $this->assertEquals('AB0123456789', $data);

    $this->expectException(ValidationException::class);
    new TaxNumber('', '');
});

test('tax number is makeable', function () {
    $valueObject = TaxNumber::make('PL0123456789');
    $this->assertSame('PL0123456789', $valueObject->value());

    $valueObject = TaxNumber::from('PL0123456789');
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
    $this->assertSame('PL', $valueObject->when(function ($vat) {
        return $vat->prefix() !== null;
    })->prefix());
    $this->assertSame($valueObject, $valueObject->when(function ($vat) {
        return $vat->prefix() === null;
    })->prefix());
});

test('tax number is arrayable', function () {
    $valueObject = new TaxNumber('PL0123456789');

    $this->assertSame([
        'fullTaxNumber' => 'PL0123456789',
        'taxNumber'     => '0123456789',
        'prefix'        => 'PL',
    ], $valueObject->toArray());
});

test('tax number is stringable', function () {
    $valueObject = new TaxNumber('PL0123456789');
    $this->assertSame($valueObject->value(), (string) $valueObject);

    $valueObject = new TaxNumber('PL0123456789');
    $this->assertSame($valueObject->value(), $valueObject->toString());
});

test('tax number has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new TaxNumber('PL0123456789');
    $this->assertSame('0123456789', $valueObject->number);
    $valueObject->tax_number = 'immutable';
});

test('tax number has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new TaxNumber('PL0123456789');
    $valueObject->__construct(' PL0123456789 ');
});

test('can extend protected methods in phone', function () {
    $phone = new TestPhone('+38 000 000 00 00');
    $this->assertSame('+38 000 000 00 00', $phone->value());
});

class TestTaxNumber extends TaxNumber
{
    public function __construct(string $number, ?string $prefix = null)
    {
        $this->number = $number;
        $this->prefix = $prefix;

        $this->validate();
        $this->sanitize();

        if ($this->canSplit()) {
            $this->split();
        }
    }

    protected function validate(): void
    {
        parent::validate();
    }

    protected function sanitize(): void
    {
        parent::sanitize();
    }

    protected function canSplit(): bool
    {
        return parent::canSplit();
    }

    protected function split(): void
    {
        parent::split();
    }
}
