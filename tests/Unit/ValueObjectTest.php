<?php

use MichaelRubel\ValueObjects\Collection\Primitive\Text;
use MichaelRubel\ValueObjects\ValueObject;

test('base value object is macroable', function () {
    ValueObject::macro('collect', function () {
        return collect($this->value());
    });
    $valueObject = new Text('Lorem ipsum');
    $this->assertSame(['Lorem ipsum'], $valueObject->collect()->toArray());
});

test('can use makeOrNull', function () {
    $this->assertNull(Text::makeOrNull(null));
    $this->assertNull(Text::makeOrNull(''));
    $this->assertNull(Text::makeOrNull('')?->value());

    $this->assertEquals(Text::make('Lorem ipsum'), Text::makeOrNull('Lorem ipsum'));
    $this->assertSame('Lorem ipsum', Text::makeOrNull('Lorem ipsum')->value());
});

test('toString casts value to string', function () {
    $vo = new TestVO;
    $this->assertSame('100', $vo->toString());
});

class TestVO extends ValueObject
{
    public function value(): int
    {
        return 100;
    }
}
