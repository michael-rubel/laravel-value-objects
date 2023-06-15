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

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Stringable;
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
 * @method static static make(string|Stringable $value)
 * @method static static from(string|Stringable $value)
 * @method static static makeOrNull(string|Stringable|null $value)
 *
 * @extends Text<TKey, TValue>
 */
class Url extends Text
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(string|Stringable $value)
    {
        parent::__construct($value);

        $this->value = url($value);

        $validator = Validator::make(
            ['url' => $this->value()],
            ['url' => $this->validationRules()],
        );

        if ($validator->fails()) {
            throw ValidationException::withMessages([__('Your URL is invalid.')]);
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
