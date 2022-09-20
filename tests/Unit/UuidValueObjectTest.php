<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use Illuminate\Support\Str;
use MichaelRubel\ValueObjects\Complex\Uuid;

test('uuid returns error if wrong uuid string', function () {
    new Uuid('test');
})->expectException(\InvalidArgumentException::class);

test('can set uuid name', function () {
    $uuid   = (string) Str::uuid();
    $result = new Uuid($uuid, 'verification');
    $this->assertSame('verification', $result->name());
});

test('can set uuid value', function () {
    $uuid   = (string) Str::uuid();
    $result = new Uuid($uuid);
    $this->assertSame($uuid, $result->value());
});

test('can cast uuid to string', function () {
    $uuid   = (string) Str::uuid();
    $string = (string) new Uuid($uuid);
    $this->assertSame($uuid, $string);
});

test('uuid value object is macroable', function () {
    $uuid = (string) Str::uuid();

    Uuid::macro('getLength', function () {
        return str($this->value())->length();
    });

    $valueObject = Uuid::make($uuid);

    assertSame(36, $valueObject->getLength());
});

test('uuid value object is conditionable', function () {
    $uuid        = (string) Str::uuid();
    $valueObject = Uuid::make($uuid);

    assertSame($uuid, $valueObject->when(true)->value());
    assertSame($valueObject, $valueObject->when(false)->value());
});

test('uuid value object is tappable', function () {
    $uuid        = (string) Str::uuid();
    $valueObject = Uuid::make($uuid);

    $valueObject->tap(function ($object) use ($valueObject) {
        assertSame($valueObject, $object);
    });
});

test('uuid value object is arrayable', function () {
    $uuid  = (string) Str::uuid();
    $array = (new Uuid($uuid, 'name'))->toArray();
    $this->assertSame([
        'name'  => 'name',
        'value' => $uuid,
    ], $array);
});
