<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Collection\Primitive\Text;
use MichaelRubel\ValueObjects\ValueObject;

test('base value object is macroable', function () {
    ValueObject::macro('collect', function () {
        return collect($this->value());
    });
    $valueObject = new Text('Lorem ipsum');
    $this->assertSame(['Lorem ipsum'], $valueObject->collect()->toArray());
});
