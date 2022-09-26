<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Contracts\Container\BindingResolutionException;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $classString)
 */
class ClassString extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $classString
     */
    public function __construct(protected ?string $classString)
    {
        //
    }

    /**
     * @return bool
     */
    public function isInstantiable(): bool
    {
        try {
            app($this->value());
        } catch (BindingResolutionException) {
            return false;
        }

        return true;
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
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return (string) $this->classString;
    }
}
