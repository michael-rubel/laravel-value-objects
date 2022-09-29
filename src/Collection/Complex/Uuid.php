<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Support\Str;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $value, string|null $name = null)
 * @method static static from(string $value, string|null $name = null)
 */
class Uuid extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string  $value
     * @param  string|null  $name
     */
    public function __construct(
        protected string $value,
        protected ?string $name = null,
    ) {
        if (! Str::isUuid($this->value)) {
            throw new \InvalidArgumentException('UUID is invalid.');
        }
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        return $this->value();
    }

    /**
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
