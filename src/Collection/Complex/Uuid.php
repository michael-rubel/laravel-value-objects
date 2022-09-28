<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $value, string $name = null)
 * @method static static from(string $value, string $name = null)
 */
class Uuid extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $value
     * @param  string|null  $name
     */
    public function __construct(
        protected ?string $value,
        protected ?string $name = null,
    ) {
        //
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        return $this->value();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return (string) $this->name;
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

    /**
     * Get an array representation of the value object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'  => $this->name(),
            'value' => $this->value(),
        ];
    }
}
