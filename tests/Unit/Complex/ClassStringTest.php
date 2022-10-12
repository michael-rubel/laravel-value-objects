<?php

declare(strict_types=1);

use Illuminate\Contracts\Container\BindingResolutionException;
use MichaelRubel\ValueObjects\Collection\Complex\ClassString;
use MichaelRubel\ValueObjects\Tests\TestCase;

test('class string cannot be empty string', function () {
    $this->expectException(\InvalidArgumentException::class);

    new ClassString('');
});

test('class string cannot be null', function () {
    $this->expectException(\TypeError::class);

    new ClassString(null);
});

test('can get class string', function () {
    $classString = new ClassString('My\Test\Class');

    $this->assertSame('My\Test\Class', $classString->value());
});

test('class string non-instantiable and class and interface are undefined', function () {
    $classString = new ClassString('My\Test\Class\NonInstantiable');

    $this->assertFalse($classString->classExists());
    $this->assertFalse($classString->interfaceExists());
});

test('class string throws binding resolution exception when trying to instantiate non-instantiable class', function () {
    $classString = new ClassString('My\Test\Class\NonInstantiable');

    $this->expectException(BindingResolutionException::class);

    $classString->instantiate();
});

test('class string is exists but interface dont', function () {
    $classString = new ClassString(ClassString::class);

    $this->assertTrue($classString->classExists());
    $this->assertFalse($classString->interfaceExists());
});

test('class string is interface & exists but class dont', function () {
    $classString = new ClassString(TestCase::class);

    $this->assertTrue($classString->classExists());
    $this->assertFalse($classString->interfaceExists());
});

test('can cast class string to string', function () {
    $classString = new ClassString(ClassString::class);

    $this->assertSame('MichaelRubel\ValueObjects\Collection\Complex\ClassString', (string) $classString);
});

test('can instantiate a class from class string value', function () {
    $classString = new ClassString('Exception');

    $this->assertEquals(new \Exception, $classString->instantiate());
    $this->assertEquals(new \Exception('test'), $classString->instantiateWith(['message' => 'test']));
});

test('class string is makeable', function () {
    $valueObject = ClassString::make('Exception');
    $this->assertSame('Exception', $valueObject->value());

    $valueObject = ClassString::from('Exception');
    $this->assertSame('Exception', $valueObject->value());
});

test('class string is macroable', function () {
    ClassString::macro('getLength', function () {
        return str($this->value())->length();
    });
    $valueObject = new ClassString('TestClass\Testing');
    $this->assertSame(17, $valueObject->getLength());
});

test('class string is conditionable', function () {
    $valueObject = new ClassString(TestCase::class);
    $this->assertTrue($valueObject->when(true)->classExists());
    $this->assertSame($valueObject, $valueObject->when(false)->classExists());
});

test('class string is arrayable', function () {
    $valueObject = new ClassString('Throwable');
    $this->assertTrue($valueObject->interfaceExists());
    $this->assertSame([$valueObject->value()], $valueObject->toArray());
});

test('class string is stringable', function () {
    $valueObject = new ClassString('Throwable');
    $this->assertSame($valueObject->value(), (string) $valueObject);
});
