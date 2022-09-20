<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use MichaelRubel\ValueObjects\ValueObject;

class ClassString implements ValueObject
{
    use Macroable, Conditionable, Tappable;

    /**
     * Create a new value object instance.
     *
     * @param string|null $classString
     */
    final public function __construct(public ?string $classString)
    {
        //
    }

    /**
     * Return a new instance of TaxNumber.
     *
     * @param string|null $classString
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
    public function isClassExists(): bool
    {
        return class_exists($this->classString);
    }

    /**
     * @return bool
     */
    public function isInterfaceExists(): bool
    {
        return interface_exists($this->classString);
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function getClassString(): string
    {
        return str($this->classString)->value();
    }

    /**
     * Return the first UUID if cast to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getClassString();
    }
}
