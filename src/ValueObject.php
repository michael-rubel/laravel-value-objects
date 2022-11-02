<?php

declare(strict_types=1);

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\Concerns\HandlesCallbacks;
use MichaelRubel\ValueObjects\Contracts\Immutable;

/**
 * Base "ValueObject".
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @implements Arrayable<TKey, TValue>
 */
abstract class ValueObject implements Arrayable, Immutable
{
    use Macroable, Conditionable, HandlesCallbacks;

    /**
     * Get the object value.
     *
     * @return mixed
     */
    abstract public function value();

    /**
     * Convenient method to create a value object statically.
     *
     * @param  mixed  $values
     *
     * @return static
     */
    public static function make(mixed ...$values): static
    {
        return new static(...$values);
    }

    /**
     * Convenient method to create a value object statically.
     *
     * @param  mixed  $values
     *
     * @return static
     */
    public static function from(mixed ...$values): static
    {
        return static::make(...$values);
    }

    /**
     * Create a value object or return null.
     *
     * @param  mixed  $values
     *
     * @return static|null
     */
    public static function makeOrNull(mixed ...$values): static|null
    {
        return rescue(fn () => static::make(...$values), report: false);
    }

    /**
     * Check if objects are instances of same class
     * and share the same properties and values.
     *
     * @param  ValueObject<int|string, mixed>  $object
     *
     * @return bool
     */
    public function equals(ValueObject $object): bool
    {
        return $this == $object;
    }

    /**
     * Inversion for `equals` method.
     *
     * @param  ValueObject<int|string, mixed>  $object
     *
     * @return bool
     */
    public function notEquals(ValueObject $object): bool
    {
        return ! $this->equals($object);
    }

    /**
     * Get an array representation of the value object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return (array) $this->value();
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value();
    }

    /**
     * Get the internal property value.
     *
     * @param  string  $name
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->{$name};
    }

    /**
     * Make sure value object is immutable.
     *
     * @param  string  $name
     * @param  mixed  $value
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function __set(string $name, mixed $value): void
    {
        throw new InvalidArgumentException(__(static::IMMUTABLE_MESSAGE));
    }
}
