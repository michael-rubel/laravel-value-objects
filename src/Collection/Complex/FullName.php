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
use InvalidArgumentException;
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
 * @method static static make(string|null $value)
 * @method static static from(string|null $value)
 *
 * @extends ValueObject<TKey, TValue>
 */
class FullName extends ValueObject
{
    /**
     * @var Collection<int, string>
     */
    protected Collection $split;

    /**
     * Create a new instance of the value object.
     *
     * @param  string  $value
     */
    public function __construct(protected string $value)
    {
        $this->split();
        $this->format();
        $this->validate();
    }

    /**
     * Get the full name.
     *
     * @return string
     */
    public function fullName(): string
    {
        return $this->value;
    }

    /**
     * Get the first name.
     *
     * @return string|null
     */
    public function firstName(): ?string
    {
        return $this->split->first();
    }

    /**
     * Get the last name.
     *
     * @return string|null
     */
    public function lastName(): ?string
    {
        return $this->split->last();
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->fullName();
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
            throw new InvalidArgumentException('Full name cannot be empty.');
        }

        if (count($this->split) < 2) {
            throw new InvalidArgumentException('Full name should have a first name and last name.');
        }
    }

    /**
     * Format the value.
     *
     * @return void
     */
    protected function format(): void
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
