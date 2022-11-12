<?php

declare(strict_types=1);

use Illuminate\Support\Stringable;
use MichaelRubel\ValueObjects\Collection\Complex\Name;

test('name replaces invisible characters', function () {
    $name = new Name(' Company Name ');
    $this->assertSame('Company Name', $name->value());

    $name = new Name('    Name!');
    $this->assertSame('Name!', $name->value());

    $name = new Name('Name@$    ');
    $this->assertSame('Name@$', $name->value());

    $name = new Name('HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,\r\nTAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI');
    $this->assertSame('HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,TAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI', $name->value());

    $name = new Name('HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,
TAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI');
    $this->assertSame('HOTEL GOŁĘBIEWSKI TADEUSZ GOŁĘBIEWSKI,TAGO PRZEDSIĘBIORSTWO PRZEMYSŁU CUKIERNICZEGO TADEUSZ GOŁĘBIEWSKI', $name->value());
});

test('name cannot accept null', function () {
    $this->expectException(\TypeError::class);

    new Name(null);
});

test('name fails when no argument passed', function () {
    $this->expectException(\TypeError::class);

    new Name;
});

test('name fails when empty string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Name('');
});

test('name is makeable', function () {
    $valueObject = Name::make('1');
    $this->assertSame('1', $valueObject->value());

    $valueObject = Name::from('1');
    $this->assertSame('1', $valueObject->value());
});

test('name is macroable', function () {
    Name::macro('str', function () {
        return str($this->value());
    });

    $valueObject = new Name('Lorem ipsum');

    $this->assertTrue($valueObject->str()->is('Lorem ipsum'));
});

test('text is conditionable', function () {
    $valueObject = new Name('1');
    $this->assertSame('1', $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('text is arrayable', function () {
    $array = (new Name('Lorem Ipsum is simply dummy text.'))->toArray();
    $this->assertSame(['Lorem Ipsum is simply dummy text.'], $array);
});

test('text is stringable', function () {
    $valueObject = new Name('Lorem ipsum');
    $this->assertSame('Lorem ipsum', (string) $valueObject);

    $valueObject = new Name('Lorem ipsum');
    $this->assertSame('Lorem ipsum', $valueObject->toString());
});

test('text accepts stringable', function () {
    $valueObject = new Name(str('Lorem ipsum'));
    $this->assertSame('Lorem ipsum', $valueObject->value());
});

test('text fails when empty stringable passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Name(str(''));
});

test('name has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Name('Lorem ipsum');
    $this->assertSame('Lorem ipsum', $valueObject->value);
    $valueObject->value = 'immutable';
});

test('name has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Name('Lorem ipsum');
    $valueObject->__construct(' Lorem ipsum ');
});

test('can extend protected methods in name', function () {
    $name = new TestName('Name');
    assertSame('Name', $name->value());
});

class TestName extends Name
{
    public function __construct(string|Stringable $value)
    {
        $this->value = $value;

        $this->sanitize();
    }

    protected function sanitize(): void
    {
        parent::sanitize();
    }
}
