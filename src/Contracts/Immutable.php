<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Contracts;

use InvalidArgumentException;

interface Immutable
{
    /**
     * The message that the object is immutable.
     *
     * @var string
     */
    public const IMMUTABLE_MESSAGE = 'Value objects are immutable, create a new object instead.';

    /**
     * Implement an immutable "set".
     *
     * @param  string  $name
     * @param  mixed  $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function __set(string $name, mixed $value): void;
}
