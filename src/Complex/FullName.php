<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use MichaelRubel\Formatters\Collection\FullNameFormatter;
use MichaelRubel\ValueObjects\ValueObject;

class FullName implements ValueObject
{
    /**
     * Create a new value object instance.
     *
     * @param string|null $first_name
     * @param string|null $last_name
     */
    final public function __construct(
        public ?string $first_name = null,
        public ?string $last_name = null,
    ) {
        //
    }

    /**
     * Return a new instance of TaxNumber.
     *
     * @param string|null $first_name
     * @param string|null $last_name
     *
     * @return static
     */
    public static function make(
        ?string $first_name = null,
        ?string $last_name = null,
    ): static {
        return new static($first_name, $last_name);
    }

    /**
     * Get the first name.
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return format(FullNameFormatter::class, $this->first_name);
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function getLastName(): string
    {
        return format(FullNameFormatter::class, $this->last_name);
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return str($this->getFirstName() . $this->getLastName())
            ->headline()
            ->value();
    }

    /**
     * Return the first UUID if cast to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFullName();
    }
}
