<?php

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

/**
 * "Email" object that represents the email address.
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
    /**
     * @var array<int, string>
     */
    protected array $split;

    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(string|Stringable $value)
    {
        parent::__construct($value);

        $this->split();
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->split[0];
    }

    /**
     * @return string
     */
    public function domain(): string
    {
        return $this->split[1];
    }

    /**
     * Get an array representation of the value object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'email'    => $this->value(),
            'username' => $this->username(),
            'domain'   => $this->domain(),
        ];
    }

    /**
     * Validate the email.
     *
     * @return void
     */
    protected function validate(): void
    {
        $validator = Validator::make(
            ['email' => $this->value()],
            ['email' => $this->validationRules()],
        );

        if ($validator->fails()) {
            throw ValidationException::withMessages(['Your email is invalid.']);
        }
    }

    /**
     * Define the rules for email validator.
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return ['required', 'email:filter,spoof'];
    }

    /**
     * Split the value by at symbol.
     *
     * @return void
     */
    protected function split(): void
    {
        $this->split = explode('@', $this->value);
    }
}
