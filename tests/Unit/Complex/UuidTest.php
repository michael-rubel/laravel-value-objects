<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use Illuminate\Support\Str;
use MichaelRubel\ValueObjects\Complex\Uuid;

test('no error if uuid string is wrong', function () {
    $valueObject = new Uuid('test');
    $this->assertSame('test', $valueObject->value());
});

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

test('uuid is macroable', function () {
    $uuid = (string) Str::uuid();
    Uuid::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = Uuid::make($uuid);
    $this->assertSame(36, $valueObject->getLength());
});

test('uuid is conditionable', function () {
    $uuid        = (string) Str::uuid();
    $valueObject = Uuid::make($uuid);
    $this->assertSame($uuid, $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('uuid is arrayable', function () {
    $uuid  = (string) Str::uuid();
    $array = (new Uuid($uuid, 'name'))->toArray();
    $this->assertSame([
        'name'  => 'name',
        'value' => $uuid,
    ], $array);
});

test('uuid is stringable', function () {
    $uuid        = (string) Str::uuid();
    $valueObject = Uuid::make($uuid);
    $this->assertSame($valueObject->value(), (string) $valueObject);
});
