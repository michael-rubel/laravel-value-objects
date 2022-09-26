<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Collection\Primitive;

use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(bool|int|string $bool)
 */
class Boolean extends ValueObject
{
    /**
     * Allowed values that are treated as `true`.
     *
     * @var array
     */
    protected array $positives = [
        '1', 'true', 'True', 'TRUE', 1, true,
    ];

    /**
     * Allowed values that are treated as `false`.
     *
     * @var array
     */
    protected array $negatives = [
        '0', 'false', 'False', 'FALSE', 0, false,
    ];

    /**
     * Create a new instance of the value object.
     *
     * @param  bool|int|string  $bool
     */
    public function __construct(protected bool|int|string $bool)
    {
        $this->bool = match (true) {
            $this->isPositive() => true,
            $this->isNegative() => false,
            default => throw new \InvalidArgumentException('Invalid boolean'),
        };
    }

    /**
     * Get the object value.
     *
     * @return bool
     */
    public function value(): bool
    {
        return (bool) $this->bool;
    }

    /**
     * Determine if the passed boolean is a positive value.
     *
     * @return bool
     */
    protected function isPositive(): bool
    {
        return in_array($this->bool, $this->positives, true);
    }

    /**
     * Determine if the passed boolean is a negative value.
     *
     * @return bool
     */
    protected function isNegative(): bool
    {
        return in_array($this->bool, $this->negatives, true);
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return ! empty($this->value()) ? 'true' : 'false';
    }
}
