<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use MichaelRubel\Formatters\Collection\TaxNumberFormatter;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string|null $number, string|null $country = null)
 * @method static static from(string|null $number, string|null $country = null)
 */
class TaxNumber extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $number
     * @param  string|null  $country
     */
    public function __construct(
        protected ?string $number = null,
        protected ?string $country = null,
    ) {
        $this->number = $this->format();

        if ($this->isWithCountry()) {
            $this->split();
        }
    }

    /**
     * Check if the tax number length is less or equal two.
     *
     * @return bool
     */
    public function isWithCountry(): bool
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
     * Get the country prefix for a given tax number.
     *
     * @return string
     */
    public function country(): string
    {
        return str($this->country)
            ->upper()
            ->value();
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
        return format(TaxNumberFormatter::class, $this->taxNumber(), $this->country());
    }

    /**
     * Split the value.
     *
     * @return void
     */
    protected function split(): void
    {
        $this->country = str($this->number)
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
            'country'       => $this->country(),
        ];
    }
}
