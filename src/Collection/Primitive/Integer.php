<?php

declare(strict_types=1);

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects\Collection\Primitive;

use MichaelRubel\ValueObjects\Concerns\SanitizesNumbers;
use MichaelRubel\ValueObjects\ValueObject;
use PHP\Math\BigNumber\BigNumber;

/**
 * "Integer" object presenting integer values.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(int|string $number)
 * @method static static from(int|string $number)
 *
 * @extends ValueObject<TKey, TValue>
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
     * @param  int|string  $number
     */
    public function __construct(int|string $number)
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
