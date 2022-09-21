<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Complex\ClassString;

test('value objects are equal', function () {
    $vo1 = new ClassString('Exception');
    $vo2 = new ClassString('Exception');
    $vo3 = new ClassString('InvalidArgumentException');

    $this->assertTrue($vo1->equals($vo2));
    $this->assertTrue($vo2->equals($vo1));

    $this->assertFalse($vo1->equals($vo3));
    $this->assertFalse($vo2->equals($vo3));
    $this->assertFalse($vo3->equals($vo1));
    $this->assertFalse($vo3->equals($vo2));
});
