<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Collection\Complex\ClassString;

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

test('value objects are not equal', function () {
    $vo1 = new ClassString('Exception');
    $vo2 = new ClassString('Exception');
    $vo3 = new ClassString('InvalidArgumentException');

    $this->assertFalse($vo1->notEquals($vo2));
    $this->assertFalse($vo2->notEquals($vo1));

    $this->assertTrue($vo1->notEquals($vo3));
    $this->assertTrue($vo2->notEquals($vo3));
    $this->assertTrue($vo3->notEquals($vo1));
    $this->assertTrue($vo3->notEquals($vo2));
});
