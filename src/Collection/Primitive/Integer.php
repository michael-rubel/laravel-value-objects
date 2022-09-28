<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Primitive;

use MichaelRubel\ValueObjects\Concerns\SanitizesNumbers;
use MichaelRubel\ValueObjects\ValueObject;
use PHP\Math\BigNumber\BigNumber;

/**
 * @method static static make(int|float|string $number)
 * @method static static from(int|float|string $number)
 */
class Integer extends ValueObject
{
    use SanitizesNumbers;

    /**
     * @var BigNumber
     */
    protected BigNumber $number;

    /**
     * Create a new instance of the value object.
     *
     * @param  int|float|string  $number
     */
    public function __construct(int|float|string $number)
    {
        $this->number = new BigNumber($this->sanitize($number), 0);
    }

    /**
     * Get the object value.
     *
     * @return int
     */
    public function value(): int
    {
        return (int) $this->number->getValue();
    }
}
