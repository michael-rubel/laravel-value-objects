<?php

declare(strict_types=1);

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * "ClassString" object presenting a class string.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string $string)
 * @method static static from(string $string)
 * @method static static makeOrNull(string|null $string)
 *
 * @extends ValueObject<TKey, TValue>
 */
class ClassString extends ValueObject
{
    /**
     * @var string
     */
    protected string $string;

    /**
     * Create a new instance of the value object.
     *
     * @param  string  $string
     */
    public function __construct(string $string)
    {
        if (isset($this->string)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->string = $string;

        $this->validate();
    }

    /**
     * Determine if the class exists for this class string.
     *
     * @return bool
     */
    public function classExists(): bool
    {
        return class_exists($this->value());
    }

    /**
     * Determine if the interface exists for this class string.
     *
     * @return bool
     */
    public function interfaceExists(): bool
    {
        return interface_exists($this->value());
    }

    /**
     * Instantiate the class string if possible.
     *
     * @param  array  $parameters
     *
     * @return object
     */
    public function instantiate(array $parameters = []): object
    {
        return app($this->value(), $parameters);
    }

    /**
     * Instantiate the class string if possible.
     *
     * @param  array  $parameters
     *
     * @return object
     */
    public function instantiateWith(array $parameters): object
    {
        return $this->instantiate($parameters);
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->string;
    }

    /**
     * Validate the value object data.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (empty($this->value())) {
            throw ValidationException::withMessages(['Class string cannot be empty.']);
        }
    }
}
