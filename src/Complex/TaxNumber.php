<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use MichaelRubel\Formatters\Collection\TaxNumberFormatter;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method make(string $taxNumber, string $country)
 */
class TaxNumber extends ValueObject implements Arrayable
{
    use Macroable, Conditionable;

    /**
     * @param  string|null  $taxNumber
     * @param  string|null  $country
     */
    public function __construct(
        protected ?string $taxNumber = null,
        protected ?string $country = null,
    ) {
        $this->taxNumber = format(TaxNumberFormatter::class, $this->taxNumber, $this->country);

        $this->when($this->isWithCountry(), function () {
            $this->country = str($this->taxNumber)
                ->substr(0, 2)
                ->upper()
                ->value();

            $this->taxNumber = str($this->taxNumber)
                ->substr(2)
                ->value();
        });
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->fullTaxNumber();
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
        return str($this->taxNumber)
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
     * Check if the tax number length is less or equal two.
     *
     * @return bool
     */
    public function isWithCountry(): bool
    {
        return strlen($this->taxNumber) >= 2 && ! is_numeric($this->taxNumber);
    }

    /**
     * Get array representation of the value object.
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

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->fullTaxNumber();
    }
}
