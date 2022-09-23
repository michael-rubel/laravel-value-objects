<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;


use MichaelRubel\ValueObjects\Collection\Primitive\Integer;

test('can get value length', function () {
    $valueObject = new Integer(100);
    $this->assertSame(3, $valueObject->length());
});
