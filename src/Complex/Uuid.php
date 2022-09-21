<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use MichaelRubel\ValueObjects\ValueObject;

class Uuid extends ValueObject implements Arrayable
{
    use Macroable, Conditionable, Tappable;

    /**
     * Create a new value object instance.
     *
     * @param  string|null  $uuid
     * @param  string|null  $name
     */
    final public function __construct(
        protected ?string $uuid,
        protected ?string $name = null,
    ) {
        //
    }

    /**
     * Return a new instance of value object.
     *
     * @param  string|null  $uuid
     * @param  string|null  $name
     *
     * @return static
     */
    public static function make(
        ?string $uuid,
        ?string $name = null,
    ): static {
        return new static($uuid, $name);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return (string) $this->name;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return (string) $this->uuid;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name'  => $this->name(),
            'value' => $this->value(),
        ];
    }

    /**
     * Return the first UUID if cast to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
