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
use Illuminate\Validation\Concerns\ValidatesAttributes;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

/**
 * "Email" object presenting a generic name.
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
class Email extends Text
{
    use ValidatesAttributes;

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
     * Validate the email.
     *
     * @return void
     */
    protected function validate(): void
    {
        $toValidate = ['email', $this->value(), $this->validationParameters()];

        if (! $this->validateEmail(...$toValidate)) {
            throw ValidationException::withMessages(['Your email is invalid.']);
        }
    }

    /**
     * Define how you want to validate the email.
     *
     * @return array
     */
    protected function validationParameters(): array
    {
        return ['filter', 'spoof', 'dns'];
    }
}
