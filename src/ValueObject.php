<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects;

class ValueObject
{
    /**
     * @param  string  $name
     * @param $value
     *
     * @return void
     */
    public function __set(string $name, $value): void
    {
        throw new \InvalidArgumentException('Value objects are immutable. You cannot modify properties. Create a new object instead.');
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
}
