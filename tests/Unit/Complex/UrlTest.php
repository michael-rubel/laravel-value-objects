<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Complex\Url;

test('can instantiate valid url', function () {
    $url = new Url('test-url');
    $this->assertSame('http://localhost/test-url', $url->value());
});

test('can url accepts query string', function () {
    $url = new Url('test-url?query=test&string=test2');
    $this->assertSame('http://localhost/test-url?query=test&string=test2', $url->value());
});

test('can url accepts full url', function () {
    $url = new Url('https://example.com/test-url?query=test&string=test2');
    $this->assertSame('https://example.com/test-url?query=test&string=test2', $url->value());
});

test('cannot instantiate invalid url', function () {
    $this->expectException(ValidationException::class);

    new Url(' Test Url ');
});

test('cannot instantiate invalid url with try/catch', function () {
    try {
        new Url(' Test Url ');
    } catch (ValidationException $exception) {
        $this->assertSame('Your URL is invalid.', $exception->getMessage());
    }
});

test('can cast url to string', function () {
    $url = new Url('test-url');
    $this->assertSame('http://localhost/test-url', (string) $url);
});

test('url cannot accept null', function () {
    $this->expectException(\TypeError::class);

    new Url(null);
});

test('url fails when no argument passed', function () {
    $this->expectException(\TypeError::class);

    new Url();
});

test('url fails when empty string passed', function () {
    $this->expectException(\InvalidArgumentException::class);

    new Url('');
});

test('url is makeable', function () {
    $valueObject = Url::make('1');
    $this->assertSame('http://localhost/1', $valueObject->value());
});

test('url is macroable', function () {
    Url::macro('str', function () {
        return str($this->value());
    });

    $valueObject = new Url('test-url');

    $this->assertTrue($valueObject->str()->is('http://localhost/test-url'));
});

test('url is conditionable', function () {
    $valueObject = new Url('1');
    $this->assertSame('http://localhost/1', $valueObject->when(true)->value());
    $this->assertSame($valueObject, $valueObject->when(false)->value());
});

test('url is arrayable', function () {
    $array = (new Url('test-url'))->toArray();
    $this->assertSame(['http://localhost/test-url'], $array);
});

test('url is stringable', function () {
    $valueObject = new Url('test-url');
    $this->assertSame('http://localhost/test-url', (string) $valueObject);

    $valueObject = new Url('test-url');
    $this->assertSame('http://localhost/test-url', $valueObject->toString());
});

test('url has immutable properties', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Url('lorem-ipsum');
    $this->assertSame('http://localhost/lorem-ipsum', $valueObject->value);
    $valueObject->value = 'immutable';
});

test('url has immutable constructor', function () {
    $this->expectException(\InvalidArgumentException::class);
    $valueObject = new Url('test-url');
    $valueObject->__construct(' Lorem ipsum ');
});

test('can extend protected methods in url', function () {
    $email = new TestUrl('test-url');
    $this->assertSame(['required', 'url'], $email->validationRules());
});

class TestUrl extends Url
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(string|Stringable $value)
    {
        parent::__construct($value);

        $this->value = url($value);

        $validator = Validator::make(
            ['url' => $this->value()],
            ['url' => $this->validationRules()],
        );

        if ($validator->fails()) {
            throw ValidationException::withMessages([__('Your URL is invalid.')]);
        }
    }

    public function validationRules(): array
    {
        return parent::validationRules();
    }
}
