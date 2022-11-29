<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Concerns;

use LengthException;
use function Psl\Str\Byte\length;

trait SanitizesNumbers
{
    /**
     * @param float|int|string|null $number
     *
     * @return string
     */
    protected function sanitize(float|int|string|null $number): string
    {
        if (! $this->is_good_float($number)) {
            throw new LengthException();
        }

        $number = str($number)->replace(',', '.');

        $dots = $number->substrCount('.');

        if ($dots >= 2) {
            $number = $number
                ->replaceLast('.', ',')
                ->replace('.', '')
                ->replaceLast(',', '.');
        }

        return $number
            ->replaceMatches('/[^0-9.]/', '')
            ->toString();
    }

    /**
     * @param float|int|string|null $number
     * @return bool
     */
    private function is_good_float(float|int|string|null $number): bool
    {
        if (is_float($number)) {
            if (length((string) ($number)) >= PHP_FLOAT_DIG) {
                return false;
            }
        }

        return true;
    }
}
