<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Primitive;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(float $double)
 */
class Double extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  float|null  $double
     */
    public function __construct(protected ?float $double)
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
