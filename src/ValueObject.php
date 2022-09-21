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
        throw new \InvalidArgumentException('Value objects are immutable, and it means you cannot modify properties. Create a new object instead.');
    }
}
