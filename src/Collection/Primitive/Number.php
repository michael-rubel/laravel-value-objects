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
 * "Number" object presenting decimal values.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(int|string $number, int $scale = 2)
 * @method static static from(int|string $number, int $scale = 2)
 * @method static static makeOrNull(int|string|null $number, int $scale = 2)
 *
 * @extends ValueObject<TKey, TValue>
 */
class Number extends ValueObject
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
