<?php

declare(strict_types=1);

use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Complex\Email;

test('email is ok', function () {
    $email = new Email('michael@laravel.software');

    $this->assertSame('michael@laravel.software', $email->value());
});

test('email is wrong', function () {
    $this->expectException(ValidationException::class);

    new Email('123');
});

test('email is wrong with at', function () {
    $this->expectException(ValidationException::class);

    new Email('laravel@framework');
});

test('email cannot accept null', function () {
    $this->expectException(\TypeError::class);

    new Email(null);
});

test('email fails when no argument passed', function () {
    $this->expectException(\TypeError::class);

    new Email;
});

test('email fails when empty string passed', function () {
    $this->expectException(ValidationException::class);

    new Email('');
});

test('email is makeable', function () {
    $valueObject = Email::make('michael@laravel.software');
    $this->assertSame('michael@laravel.software', $valueObject->value());

    $valueObject = Email::from('michael@laravel.software');
    $this->assertSame('michael@laravel.software', $valueObject->value());
});

test('email is macroable', function () {
    Email::macro('str', function () {
        return str($this->value());
    });

    $valueObject = new Email('michael@laravel.software');

    $this->assertTrue($valueObject->str()->is('michael@laravel.software'));
});

test('email is conditionable', function () {
    $valueObject = new Email('michael@laravel.software');
    $this->assertSame('michael@laravel.software', $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('email is arrayable', function () {
    $array = (new Email('michael@laravel.software'))->toArray();
    $this->assertSame(['michael@laravel.software'], $array);
});

test('email is stringable', function () {
    $valueObject = new Email('michael@laravel.software');
    $this->assertSame('michael@laravel.software', (string) $valueObject);
});

test('email accepts stringable', function () {
    $valueObject = new Email(str('michael@laravel.software'));
    $this->assertSame('michael@laravel.software', $valueObject->value());
});

test('email fails when empty stringable passed', function () {
    $this->expectException(ValidationException::class);

    new Email(str(''));
});
