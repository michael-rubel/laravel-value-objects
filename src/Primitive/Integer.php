<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Primitive;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(int $integer)
 */
class Integer extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  int|null  $integer
     */
    public function __construct(protected ?int $integer)
    {
        //
    }

    /**
     * Get the object value.
     *
     * @return int
     */
    public function value(): int
    {
        return (int) $this->integer;
    }
}
