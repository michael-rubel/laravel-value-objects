<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $uuid, string $name)
 */
class Uuid extends ValueObject
{
    use Macroable, Conditionable;

    /**
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
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
