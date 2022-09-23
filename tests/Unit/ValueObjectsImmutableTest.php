<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use Illuminate\Support\Str;
use MichaelRubel\ValueObjects\Collection\Complex\ClassString;
use MichaelRubel\ValueObjects\Collection\Complex\FullName;
use MichaelRubel\ValueObjects\Collection\Complex\TaxNumber;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

test('class string value object is immutable', function () {
    $valueObject              = new ClassString('Exception');
    $valueObject->classString = 'immutable';
})->expectException(\InvalidArgumentException::class);

test('full name value object is immutable', function () {
    $valueObject            = new FullName('Michael');
    $valueObject->full_name = 'immutable';
})->expectException(\InvalidArgumentException::class);

test('tax number value object is immutable', function () {
    $valueObject             = new TaxNumber('PL0123456789');
    $valueObject->tax_number = 'immutable';
})->expectException(\InvalidArgumentException::class);

test('uuid value object is immutable', function () {
    $uuid                    = (string) Str::uuid();
    $valueObject             = new Uuid($uuid);
    $valueObject->tax_number = 'immutable';
})->expectException(\InvalidArgumentException::class);
