<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

abstract class ValueObject implements Arrayable
{
    /**
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
     * Check if objects are instances of same class
     * and share the same properties and values.
     *
     * @param  ValueObject  $object
     *
     * @return bool
     */
    public function equals(ValueObject $object): bool
    {
        return $this == $object;
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
        throw new \InvalidArgumentException('Value objects are immutable. You cannot modify properties. Create a new object instead.');
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
