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
//        dump('OOOOOOOOkkkkkkkkkkKKKKKKKK', $this->is_good_float($number));

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
            $number_string = (string) $number;
            $array_number = explode('.',$number_string);
            $precision = length($array_number[1] ?? '');
//            dump('>',$array_number, $precision,'<<');
            $number2 = round($number,  $precision , PHP_ROUND_HALF_DOWN);
//            dump(
//                $number2 ,
////                round($number,  $precision + 0, PHP_ROUND_HALF_DOWN)  ,
////                round($number,  $precision + 1, PHP_ROUND_HALF_DOWN)  ,
//                '^^^^^^^'
//            );
if($precision) {
    $number2 = ($number / (10 * $precision));
    $number2 = ($number2 * 10 * $precision);
}
//            dump('ssssssssssssssss',
//                PHP_FLOAT_DIG ,
//                length($number_string),
//                $number,
////'--',PHP_FLOAT_MIN ,PHP_FLOAT_MAX ,PHP_FLOAT_DIG ,
//                '********',
//                $number2,
//                $number2 == $number,
//                length($number_string) >= PHP_FLOAT_DIG - 1,
//                length($number_string) >= (PHP_FLOAT_DIG - 1),
//                length($number_string) ,
//                PHP_FLOAT_DIG - 1,
//                PHP_FLOAT_DIG,
//                '=======');
            if (length($number_string) >= PHP_FLOAT_DIG - 1 || $number2 !== $number) {
                return false;
            }
        }

        return true;
    }
}
