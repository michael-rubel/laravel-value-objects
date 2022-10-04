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

use MichaelRubel\ValueObjects\ValueObject;

/**
 * "ClassString" object presenting a class string.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string|null $string)
 * @method static static from(string|null $string)
 *
 * @extends ValueObject<TKey, TValue>
 */
class ClassString extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $string
     */
    public function __construct(protected ?string $string)
    {
        //
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
    public function instantiateWith(array $parameters = []): object
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
        return (string) $this->string;
    }
}
