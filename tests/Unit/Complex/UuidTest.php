<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

test('can get uuid using uuid method', function () {
    $uuid        = (string) Str::uuid();
    $valueObject = new Uuid($uuid);
    $this->assertSame($uuid, $valueObject->uuid());
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

test('ails when wrong uuid passed to uuid object', function () {
    $this->expectException(ValidationException::class);

    new Uuid('123');
});

test('fails when null passed to uuid', function () {
    $this->expectException(\TypeError::class);

    new Uuid(null);
});

test('full name is makeable', function () {
    $uuid = (string) Str::uuid();

    $valueObject = Uuid::make($uuid);
    $this->assertSame($uuid, $valueObject->value());

    $valueObject = Uuid::from($uuid);
    $this->assertSame($uuid, $valueObject->value());
});

test('uuid is macroable', function () {
    $uuid = (string) Str::uuid();
    Uuid::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = new Uuid($uuid);
    $this->assertSame(36, $valueObject->getLength());
});

test('uuid is conditionable', function () {
    $uuid        = (string) Str::uuid();
    $valueObject = new Uuid($uuid);
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
    $valueObject = new Uuid($uuid);
    $this->assertSame($valueObject->value(), (string) $valueObject);
});
