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

use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * "Uuid" object presenting unique ID.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string $value, string|null $name = null)
 * @method static static from(string $value, string|null $name = null)
 * @method static static makeOrNull(string|null $value, string|null $name = null)
 *
 * @extends ValueObject<TKey, TValue>
 */
class Uuid extends ValueObject
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * @var string|null
     */
    protected ?string $name = null;

    /**
     * Create a new instance of the value object.
     *
     * @param  string  $value
     * @param  string|null  $name
     */
    public function __construct(string $value, ?string $name = null)
    {
        if (isset($this->value)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->value = $value;
        $this->name  = $name;

        $this->validate();
    }

    /**
     * Get the UUID value.
     *
     * @return string
     */
    public function uuid(): string
    {
        return $this->value();
    }

    /**
     * Get the UUID name if present.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * Get an array representation of the value object.
     *
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        return [
            'name'  => $this->name(),
            'value' => $this->value(),
        ];
    }

    /**
     * Validate the value object data.
     *
     * @return void
     */
    protected function validate(): void
    {
        if (! str($this->value())->isUuid()) {
            throw ValidationException::withMessages(['UUID is invalid.']);
        }
    }
}
