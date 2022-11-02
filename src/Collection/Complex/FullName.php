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

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Illuminate\Validation\ValidationException;
use MichaelRubel\Formatters\Collection\FullNameFormatter;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * "FullName" object presenting a full name.
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
 * @extends ValueObject<TKey, TValue>
 */
class FullName extends Name
{
    /**
     * @var Collection<int, string>
     */
    protected Collection $split;

    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable  $value
     */
    public function __construct(string|Stringable $value)
    {
        static::beforeParentCalls(fn () => $this->split());

        parent::__construct($value);
    }

    /**
     * Get the full name.
     *
     * @return string
     */
    public function fullName(): string
    {
        return $this->value();
    }

    /**
     * Get the first name.
     *
     * @return string
     */
    public function firstName(): string
    {
        return (string) $this->split->first();
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function lastName(): string
    {
        return (string) $this->split->last();
    }

    /**
     * Get an array representation of the value object.
     *
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'fullName'  => $this->fullName(),
            'firstName' => $this->firstName(),
            'lastName'  => $this->lastName(),
        ];
    }

    /**
     * Validate the value object data.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (empty($this->value())) {
            throw ValidationException::withMessages([__('Full name cannot be empty.')]);
        }

        if (count($this->split) < 2) {
            throw ValidationException::withMessages([__('Full name should have a first name and last name.')]);
        }
    }

    /**
     * Sanitize the value.
     *
     * @return void
     */
    protected function sanitize(): void
    {
        $this->value = format(FullNameFormatter::class, $this->value());
    }

    /**
     * Split the value.
     *
     * @return void
     */
    protected function split(): void
    {
        $this->split = str($this->value())->split('/\s/');
    }
}
