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

use MichaelRubel\Formatters\Collection\TaxNumberFormatter;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * "TaxNumber" object presenting VAT identification number.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(string|null $number, string|null $prefix = null)
 * @method static static from(string|null $number, string|null $prefix = null)
 *
 * @extends ValueObject<TKey, TValue>
 */
class TaxNumber extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $number
     * @param  string|null  $prefix
     */
    public function __construct(
        protected ?string $number = null,
        protected ?string $prefix = null,
    ) {
        $this->number = $this->format();

        if ($this->isWithPrefix()) {
            $this->split();
        }
    }

    /**
     * Check if the tax number length is less or equal two.
     *
     * @return bool
     */
    public function isWithPrefix(): bool
    {
        return strlen($this->number) >= 2 && ! is_numeric($this->number);
    }

    /**
     * Get the tax number with a country prefix.
     *
     * @return string
     */
    public function fullTaxNumber(): string
    {
        return $this->country() . $this->taxNumber();
    }

    /**
     * Get the tax number without country prefix.
     *
     * @return string
     */
    public function taxNumber(): string
    {
        return str($this->number)
            ->upper()
            ->value();
    }

    /**
     * Get the tax number prefix.
     *
     * @return string
     */
    public function prefix(): string
    {
        return str($this->prefix)
            ->upper()
            ->value();
    }

    /**
     * Get the country prefix for a given tax number.
     *
     * @return string
     */
    public function country(): string
    {
        return $this->prefix();
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->fullTaxNumber();
    }

    /**
     * Format the value.
     *
     * @return string
     */
    protected function format(): string
    {
        return format(TaxNumberFormatter::class, $this->taxNumber(), $this->prefix());
    }

    /**
     * Split the value.
     *
     * @return void
     */
    protected function split(): void
    {
        $this->prefix = str($this->number)
            ->substr(0, 2)
            ->upper()
            ->value();

        $this->number = str($this->number)
            ->substr(2)
            ->value();
    }

    /**
     * Get an array representation of the value object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'fullTaxNumber' => $this->fullTaxNumber(),
            'taxNumber'     => $this->taxNumber(),
            'prefix'        => $this->prefix(),
        ];
    }
}
