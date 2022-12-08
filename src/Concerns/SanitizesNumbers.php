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
        if (is_float($number) && ! $this->is_good_float($number)) {
            throw new LengthException();
        }

        $number = str((string) $number)->replace(',', '.');

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
            $array_number = str((string) $number)->explode('.');

            $precision_position = length($array_number->get(1, ''));

            $round_number = round($number,  $precision_position );

            $sum_digits = $array_number->sum(function($item) {
                return length($item);
            });

            if (($round_number == $number  && $sum_digits <= PHP_FLOAT_DIG - 1)) { //|| $number2 !== $number
                return true;
            }
        }

        return false;
    }


}
