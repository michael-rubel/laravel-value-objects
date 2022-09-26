<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Complex;

use Illuminate\Support\Collection;
use MichaelRubel\Formatters\Collection\FullNameFormatter;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $name)
 */
class FullName extends ValueObject
{
    /**
     * @var Collection
     */
    protected Collection $split;

    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $name
     */
    public function __construct(protected ?string $name)
    {
        $this->name = format(FullNameFormatter::class, $this->name);

        $this->split = str($this->name)->split('/\s/');
    }

    /**
     * Get the full name.
     *
     * @return string
     */
    public function fullName(): string
    {
        return (string) $this->name;
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
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->fullName();
    }

    /**
     * Get an array representation of the value object.
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
}
