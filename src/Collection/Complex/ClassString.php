<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string|null $string)
 * @method static static from(string|null $string)
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
     * @return object
     */
    public function instantiate(): object
    {
        return app($this->value());
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
        return app($this->value(), $parameters);
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
