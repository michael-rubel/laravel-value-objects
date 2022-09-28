<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $string)
 * @method static static from(string $string)
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
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return (string) $this->string;
    }
}
