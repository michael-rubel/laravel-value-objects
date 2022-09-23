<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Primitive;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(int|float|string|null $double)
 */
class Double extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  int|float|string|null  $double
     */
    public function __construct(protected int|float|string|null $double)
    {
        //
    }

    /**
     * Get the object value.
     *
     * @return float
     */
    public function value(): float
    {
        return (float) $this->double;
    }
}
