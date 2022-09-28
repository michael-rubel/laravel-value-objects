<?php

namespace Olsza\ValueObjects\Tests\Feature\ValueObjects;

use MichaelRubel\ValueObjects\Collection\Complex\ClassString;
use MichaelRubel\ValueObjects\Collection\Primitive\Decimal;

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

test('decimal object equality works as expected', function () {
    $vo1 = new Decimal(777177711191777.97999999999998, scale: 2);
    $vo2 = new Decimal('777177711191777.97999999999998', scale: 3);
    $vo3 = new Decimal('777177711191777.97999999999998', scale: 2);
    $vo4 = clone $vo1;

    $this->assertFalse($vo1->equals($vo2));
    $this->assertTrue($vo1->notEquals($vo2));
    $this->assertTrue($vo3->equals($vo1));
    $this->assertTrue($vo4->equals($vo1));
});
