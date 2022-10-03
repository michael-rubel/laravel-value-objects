<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Primitive;

use Illuminate\Support\Stringable;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string|Stringable|null $value)
 * @method static static from(string|Stringable|null $value)
 */
class Text extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|Stringable|null  $value
     */
    public function __construct(protected string|Stringable|null $value)
    {
        //
    }

    /**
     * Get the object value.
     *
     * @return string
     */
    public function value(): string
    {
        return (string) $this->value;
    }
}
