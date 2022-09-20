<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;
use MichaelRubel\Formatters\Collection\FullNameFormatter;
use MichaelRubel\ValueObjects\ValueObject;

class FullName implements ValueObject, Arrayable
{
    use Macroable, Conditionable, Tappable;

    /**
     * @var Collection
     */
    protected Collection $split;

    /**
     * Create a new value object instance.
     *
     * @param  string|null  $full_name
     */
    final public function __construct(public ?string $full_name)
    {
        $this->full_name = format(FullNameFormatter::class, $this->full_name);

        $this->split = str($this->full_name)->split('/\s/');
    }

    /**
     * Return a new instance of TaxNumber.
     *
     * @param  string|null  $name
     *
     * @return static
     */
    public static function make(?string $name): static
    {
        return new static($name);
    }

    /**
     * Get the first name.
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->split->first();
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->split->last();
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'full_name'  => $this->getFullName(),
            'first_name' => $this->getFirstName(),
            'last_name'  => $this->getLastName(),
        ];
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
