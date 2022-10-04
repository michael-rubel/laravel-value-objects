<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements Arrayable<TKey, TValue>
 */
abstract class ValueObject implements Arrayable
{
    use Macroable, Conditionable;

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
     */
    public function __set(string $name, mixed $value): void
    {
        throw new \InvalidArgumentException('Value objects are immutable. You cannot modify properties, create a new object instead.');
    }
}
