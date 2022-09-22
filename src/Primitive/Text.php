<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Primitive;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $text)
 */
class Text extends ValueObject
{
    /**
     * Create a new instance of the value object.
     *
     * @param  string|null  $text
     */
    public function __construct(protected ?string $text)
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
        return (string) $this->text;
    }
}
