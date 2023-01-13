<?php

declare(strict_types=1);

use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Complex\Phone;

test('phone is ok', function () {
    $phone = new Phone('+38 000 000 00 00');
    $this->assertSame('+38 000 000 00 00', $phone->value());

    $phone = new Phone('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', $phone->value());

    $phone = new Phone('+48000000000');
    $this->assertSame('+48000000000', $phone->value());
});

test('phone is squished', function () {
    $phone = new Phone(' +38 000 000 00 00 ');
    $this->assertSame('+38 000 000 00 00', $phone->value());
});

test('phone allows short version', function () {
    $phone = new Phone('00000');
    $this->assertSame('00000', $phone->value());

    $phone = new Phone('000 000 000');
    $this->assertSame('000 000 000', $phone->value());

    $phone = new Phone('000000000');
    $this->assertSame('000000000', $phone->value());
});

test('phone is sanitized', function () {
    $phone = new Phone('+48 00 000 00 00');
    $this->assertSame('+48000000000', $phone->sanitized());

    $phone = new Phone('00 000 00 00');
    $this->assertSame('000000000', $phone->sanitized());
});

test('phone deals with line-break', function () {
    $phone = new Phone('+38 000
000 00 00');
    $this->assertSame('+380000000000', $phone->sanitized());
});

test('phone accepts only one plus character', function () {
    $this->expectException(ValidationException::class);
    new Phone('++38 000 000 00');
});

test('phone rejects plus if it is not the first char', function () {
    $this->expectException(ValidationException::class);
    new Phone('38 000 +000 000');
});

test('phone rejects plus when it is the last char', function () {
    $this->expectException(ValidationException::class);
    new Phone('38 000 000 000+');
});

test('phone fails when wrong number passed', function () {
    $this->expectException(ValidationException::class);
    new Phone('123');
});

test('validation exception message is correct in phone', function () {
    try {
        new Phone('123');
    } catch (ValidationException $e) {
        $this->assertSame(__('Your phone number is invalid.'), $e->getMessage());
    }
});

test('phone cannot accept null', function () {
    $this->expectException(\TypeError::class);
    new Phone(null);
});

test('phone fails when no argument passed', function () {
    $this->expectException(\TypeError::class);
    new Phone;
});

test('phone fails when empty string passed', function () {
    $this->expectException(ValidationException::class);
    new Phone('');
});

test('phone is makeable', function () {
    $valueObject = Phone::make('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', $valueObject->value());

    $valueObject = Phone::from('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', $valueObject->value());
});

test('phone is macroable', function () {
    Phone::macro('str', function () {
        return str($this->value());
    });

    $valueObject = new Phone('+48 00 000 00 00');

    $this->assertTrue($valueObject->str()->is('+48 00 000 00 00'));
});

test('phone is conditionable', function () {
    $valueObject = new Phone('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('phone is arrayable', function () {
    $array = (new Phone('+48 00 000 00 00'))->toArray();
    $this->assertSame(['+48 00 000 00 00'], $array);
});

test('phone is stringable', function () {
    $valueObject = new Phone('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', (string) $valueObject);

    $valueObject = new Phone('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', $valueObject->toString());
});

test('phone accepts stringable', function () {
    $valueObject = new Phone(str('+48 00 000 00 00'));
    $this->assertSame('+48 00 000 00 00', $valueObject->value());
});

test('phone fails when empty stringable passed', function () {
    $this->expectException(ValidationException::class);
    new Phone(str(''));
});

test('phone is immutable', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Phone('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', $valueObject->value);
    $valueObject->value = 'immutable';
});

test('phone has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Phone('+48 00 000 00 00');
    $this->assertSame('+48 00 000 00 00', $valueObject->value);
    $valueObject->value = 'immutable';
});

test('phone has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Phone('+48 00 000 00 00');
    $valueObject->__construct('+38 000 000 00 00');
});

test('can extend protected methods in phone', function () {
    $phone = new TestPhone('+38 000 000 00 00');
    $this->assertSame('+38 000 000 00 00', $phone->value());
});

class TestPhone extends Phone
{
    public function __construct(string|Stringable $value)
    {
        $this->value = $value;

        $this->trim();
    }

    protected function trim(): void
    {
        parent::trim();
    }
}
