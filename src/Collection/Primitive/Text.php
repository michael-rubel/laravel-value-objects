<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Primitive;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(int|float|string|null $value)
 * @method static static from(int|float|string|null $value)
 */
class Text extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  int|float|string|null  $value
     */
    public function __construct(protected int|float|string|null $value)
    {
        //
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return (string) $this->value;
    }
}
