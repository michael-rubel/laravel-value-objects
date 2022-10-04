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

use Illuminate\Support\Stringable;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * "Text" object presenting the stringable values.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string|Stringable|null $value)
 * @method static static from(string|Stringable|null $value)
 *
 * @extends ValueObject<TKey, TValue>
 */
class Text extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable|null  $value
     */
    public function __construct(protected string|Stringable|null $value)
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
