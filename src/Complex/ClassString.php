<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use MichaelRubel\ValueObjects\ValueObject;

class ClassString extends ValueObject
{
    use Macroable, Conditionable, Tappable;

    /**
     * Create a new value object instance.
     *
     * @param  string|null  $classString
     */
    final public function __construct(protected ?string $classString)
    {
        //
    }

    /**
     * Return a new instance of value object.
     *
     * @param  string|null  $classString
     *
     * @return static
     */
    public static function make(?string $classString): static
    {
        return new static($classString);
    }

    /**
     * @return bool
     */
    public function classExists(): bool
    {
        return class_exists($this->value());
    }

    /**
     * @return bool
     */
    public function interfaceExists(): bool
    {
        return interface_exists($this->value());
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function value(): string
    {
        return (string) $this->classString;
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
