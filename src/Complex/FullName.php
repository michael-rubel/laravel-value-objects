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

class FullName extends ValueObject implements Arrayable
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
    final public function __construct(protected ?string $full_name)
    {
        $this->full_name = format(FullNameFormatter::class, $this->full_name);

        $this->split = str($this->full_name)->split('/\s/');
    }

    /**
     * Return a new instance of value object.
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
     * Get the last name.
     *
     * @return string
     */
    public function fullName(): string
    {
        return (string) $this->full_name;
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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'full_name'  => $this->fullName(),
            'first_name' => $this->firstName(),
            'last_name'  => $this->lastName(),
        ];
    }

    /**
     * Return the first UUID if cast to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->fullName();
    }
}
