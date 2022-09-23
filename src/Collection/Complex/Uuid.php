<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $uuid, string $name = null)
 */
class Uuid extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $uuid
     * @param  string|null  $name
     */
    public function __construct(
        protected ?string $uuid,
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
        return (string) $this->uuid;
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
