<?php

declare(strict_types=1);

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Support\Stringable;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

/**
 * "Name" object presenting a generic name.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string|Stringable $value)
 * @method static static from(string|Stringable $value)
 * @method static static makeOrNull(string|Stringable|null $value)
 *
 * @extends Text<TKey, TValue>
 */
class Name extends Text
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(string|Stringable $value)
    {
        parent::__construct($value);

        $this->sanitize();
    }

    /**
     * Sanitize the value.
     *
     * @return void
     */
    protected function sanitize(): void
    {
        $this->value = str($this->value())
            ->replaceMatches('/\p{C}+/u', '')
            ->replace(['\r', '\n', '\t'], '')
            ->squish()
            ->value();
    }
}
