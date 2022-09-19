<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use MichaelRubel\Formatters\Collection\TaxNumberFormatter;
use MichaelRubel\ValueObjects\ValueObject;

class TaxNumber implements ValueObject, Arrayable
{
    use Macroable, Conditionable, Tappable;

    /**
     * Create a new value object instance.
     *
     * @param  string|null  $tax_number
     * @param  string|null  $country
     */
    final public function __construct(
        public ?string $tax_number = null,
        public ?string $country = null
    ) {
        $this->tax_number = format(
            TaxNumberFormatter::class,
            [$this->tax_number, $this->country]
        );

        $this->when($this->isWithCountry(), function () {
            $this->country = str($this->tax_number)
                ->substr(0, 2)
                ->upper()
                ->value();

            $this->tax_number = str($this->tax_number)
                ->substr(2)
                ->value();
        });
    }

    /**
     * Return a new instance of TaxNumber.
     *
     * @param  string|null  $tax_number
     * @param  string|null  $country
     *
     * @return static
     */
    public static function make(?string $tax_number, ?string $country = null): static
    {
        return new static($tax_number, $country);
    }

    /**
     * Check if the tax number length is less or equal two.
     *
     * @return bool
     */
    public function isWithCountry(): bool
    {
        return strlen($this->tax_number) >= 2
            && ! is_numeric($this->tax_number);
    }

    /**
     * Get the tax number.
     *
     * @return string
     */
    public function getTaxNumber(): string
    {
        return str($this->tax_number)
            ->upper()
            ->value();
    }

    /**
     * Get the country prefix.
     *
     * @return string
     */
    public function getCountry(): string
    {
        return str($this->country)
            ->upper()
            ->value();
    }

    /**
     * Get a full tax number for a given value object.
     * The tax number with a country prefix.
     *
     * @return string
     */
    public function getFullTaxNumber(): string
    {
        return $this->getCountry() . $this->getTaxNumber();
    }

    /**
     * Get the array representation of the value object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'full_tax_number' => $this->getFullTaxNumber(),
            'tax_number'      => $this->tax_number,
            'country'         => $this->getCountry(),
        ];
    }

    /**
     * Get the raw string value.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFullTaxNumber();
    }
}
