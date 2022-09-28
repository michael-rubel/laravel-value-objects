<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Primitive;

use MichaelRubel\ValueObjects\Concerns\SanitizesNumbers;
use MichaelRubel\ValueObjects\ValueObject;
use PHP\Math\BigNumber\BigNumber;

/**
 * @method static static make(int|string $number, int $scale = 2)
 * @method static static from(int|string $number, int $scale = 2)
 */
class Decimal extends ValueObject
{
    use SanitizesNumbers;

    /**
     * @var BigNumber
     */
    protected BigNumber $number;

    /**
     * Create a new instance of the value object.
     *
     * @param  int|string  $number
     * @param  int  $scale
     */
    public function __construct(int|string $number, protected int $scale = 2)
    {
        $this->number = new BigNumber($this->sanitize($number), $this->scale);
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
