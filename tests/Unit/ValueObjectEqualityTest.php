<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\ClassString;

test('value objects are equal', function () {
    $vo1 = new ClassString('Exception');
    $vo2 = new ClassString('Exception');
    $vo3 = new ClassString('InvalidArgumentException');

    assertTrue($vo1->equals($vo2));
    assertTrue($vo2->equals($vo1));

    assertFalse($vo1->equals($vo3));
    assertFalse($vo2->equals($vo3));
    assertFalse($vo3->equals($vo1));
    assertFalse($vo3->equals($vo2));
});

