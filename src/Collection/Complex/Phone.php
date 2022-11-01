<?php

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

/**
 * "Phone" object that represents a telephone number.
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
class Phone extends Text
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(protected string|Stringable $value)
    {
        parent::__construct($this->value);

        $this->validate();
    }

    /**
     * Get the sanitized phone number.
     *
     * @return string
     */
    public function sanitized(): string
    {
        return str($this->value())
            ->replace(' ', '')
            ->replaceMatches('/\p{C}+/u', '')
            ->value();
    }

    /**
     * Validate the phone number.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (! preg_match('/^[+]?[0-9 ]{7,15}$/', $this->sanitized())) {
            throw ValidationException::withMessages([__('Your phone number is invalid.')]);
        }
    }
}
