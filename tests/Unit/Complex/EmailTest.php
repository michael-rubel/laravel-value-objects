<?php

declare(strict_types=1);

use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Complex\Email;

test('email is ok', function () {
    $email = new Email('michael@laravel.software');

    $this->assertSame('michael@laravel.software', $email->value());
});

test('email has username', function () {
    $email = new Email('michael@laravel.software');

    $this->assertSame('michael', $email->username());
});

test('email has domain', function () {
    $email = new Email('michael@laravel.software');

    $this->assertSame('laravel.software', $email->domain());
});

test('email is wrong', function () {
    $this->expectException(ValidationException::class);

    new Email('123');
});

test('email is wrong with at', function () {
    $this->expectException(ValidationException::class);

    new Email('laravel@framework');
});

test('validation exception message is correct in email', function () {
    try {
        new Email('');
    } catch (ValidationException $e) {
        $this->assertSame(__('Your email is invalid.'), $e->getMessage());
    }
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
    $this->assertSame([
        'email'    => 'michael@laravel.software',
        'username' => 'michael',
        'domain'   => 'laravel.software',
    ], $array);
});

test('email is stringable', function () {
    $valueObject = new Email('michael@laravel.software');
    $this->assertSame('michael@laravel.software', (string) $valueObject);

    $valueObject = new Email('michael@laravel.software');
    $this->assertSame('michael@laravel.software', $valueObject->toString());
});

test('email accepts stringable', function () {
    $valueObject = new Email(str('michael@laravel.software'));
    $this->assertSame('michael@laravel.software', $valueObject->value());
});

test('email fails when empty stringable passed', function () {
    $this->expectException(ValidationException::class);

    new Email(str(''));
});

test('email has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Email('contact@observer.name');
    $this->assertSame('contact@observer.name', $valueObject->value);
    $valueObject->value = 'immutable';
});

test('email has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Email('contact@observer.name');
    $valueObject->__construct('contact@observer.com');
});

test('can extend protected methods in email', function () {
    $email = new TestEmail('contact@observer.name');
    $this->assertSame(['required', 'email:filter,spoof'], $email->validationRules());
    $this->assertSame(['filter', 'spoof'], $email->validationParameters());
});

class TestEmail extends Email
{
    public function __construct(string|Stringable $value)
    {
        $this->value = $value;

        $this->validate();
        $this->split();
    }

    public function validationRules(): array
    {
        return parent::validationRules();
    }

    public function validationParameters(): array
    {
        return parent::validationParameters();
    }
}
