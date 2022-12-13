<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Concerns;

use LengthException;

trait SanitizesNumbers
{
    /**
     * @param  int|string|float|null  $number
     *
     * @return string
     */
    protected function sanitize(int|string|float|null $number): string
    {
        if (is_float($number) && ! $this->isGoodFloat($number)) {
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
     * @param  int|string|float|null  $number
     * @return bool
     */
    private function isGoodFloat(int|string|float|null $number): bool
    {
        if (is_float($number)) {
            $separated = str($number)->explode('.');

            $precision_position = str($separated->get(1, ''))->length();

            $round_number = round($number, $precision_position);

            $sum_digits = $separated->sum(function ($item) {
                return str($item)->length();
            });

            if (($round_number == $number && $sum_digits <= PHP_FLOAT_DIG - 1)) {
                return true;
            }
        }

        return false;
    }
}
