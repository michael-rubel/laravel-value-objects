<?php

declare(strict_types=1);

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2023 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use MichaelRubel\ValueObjects\Collection\Primitive\Text;

/**
 * "Url" object presenting a URL.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string $value)
 * @method static static from(string $value)
 * @method static static makeOrNull(string|null $value)
 *
 * @extends Text<TKey, TValue>
 */
class Url extends Text
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->value = url($value);

        $validator = Validator::make(
            ['url' => $this->value()],
            ['url' => $this->validationRules()],
        );

        if ($validator->fails()) {
            throw ValidationException::withMessages(['Your URL is invalid.']);
        }
    }

    /**
     * Define the rules for email validator.
     *
     * @return array
     */
    protected function validationRules(): array
    {
        return ['required', 'url'];
    }
}
