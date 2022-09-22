<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use MichaelRubel\Formatters\Collection\FullNameFormatter;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method make(string $taxNumber)
 */
class FullName extends ValueObject implements Arrayable
{
    use Macroable, Conditionable;

    /**
     * @var Collection
     */
    protected Collection $split;

    /**
     * @param  string|null  $fullName
     */
    public function __construct(protected ?string $fullName)
    {
        $this->fullName = format(FullNameFormatter::class, $this->fullName);

        $this->split = str($this->fullName)->split('/\s/');
    }

    /**
     * Get the full name.
     *
     * @return string
     */
    public function fullName(): string
    {
        return (string) $this->fullName;
    }

    /**
     * Get the first name.
     *
     * @return string
     */
    public function firstName(): string
    {
        return $this->split->first();
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function lastName(): string
    {
        return $this->split->last();
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->fullName();
    }

    /**
     * Get array representation of the value object.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'fullName'  => $this->fullName(),
            'firstName' => $this->firstName(),
            'lastName'  => $this->lastName(),
        ];
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->fullName();
    }
}
