<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Primitive;

use MichaelRubel\ValueObjects\ValueObject;
use PHP\Math\BigNumber\BigNumber;

/**
 * @method static static make(int|float|string|null $number, int $scale = 2)
 */
class Decimal extends ValueObject
{
    /**
     * @var BigNumber
     */
    protected BigNumber $number;

    /**
     * Create a new instance of the value object.
     *
     * @param  int|float|string|null  $number
     * @param  int  $scale
     */
    public function __construct(int|float|string|null $number, protected int $scale = 2)
    {
        $filtered = str($number ?? '0')
            ->replace(',', '.')
            ->value();

        $this->number = new BigNumber($filtered, $this->scale);
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return (string) $this->number;
    }
}
