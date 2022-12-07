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
            $numer_int = (int) $number_string;
//            $array_number = explode('.', $number_string);
            $array_number = str($number)->explode('.');
            $precision = length($array_number->get(1, ''));
           $sum = $array_number->sum(function($item) {
              return length($item);
           });
            dump('cccccccccccc', $sum);
            dump('>',$array_number, $precision,'<<',length($number_string),'<<<<',PHP_FLOAT_DIG - 1);
            $number2 = round($number,  $precision , PHP_ROUND_HALF_DOWN);
            dump('++++++++++++',
                $number_string,
                $numer_int,
                $numer_int == $number,
                '--------',
                $number,
                $precision,
//                round($number,  $precision , PHP_ROUND_HALF_DOWN),
//                round($number,  $precision , PHP_ROUND_HALF_UP),
//                round($number,  $precision , PHP_ROUND_HALF_ODD),
//                round($number,  $precision , PHP_ROUND_HALF_EVEN),

            '***************'
            );
//            dump(
//                $number2 ,
////                round($number,  $precision + 0, PHP_ROUND_HALF_DOWN)  ,
////                round($number,  $precision + 1, PHP_ROUND_HALF_DOWN)  ,
//                '^^^^^^^'
//            );
            dump('PPP', $number2);
if($precision) {
    $number3 = ($number * pow(10, $precision+5) * 9);
    $number3str = (string) $number3;

    dump('PPP-', $number3,$number3str );

    $number4= ($number2 / 9 / pow(10, $precision+5));
    $number4str = (string) $number4;

    dump('PPP+', $number4,$number4str);
}
            dump('ssssssNUMBERssssssssss',
//                PHP_FLOAT_DIG ,
//                length($number_string),
                $number,
////'--',PHP_FLOAT_MIN ,PHP_FLOAT_MAX ,PHP_FLOAT_DIG ,
//                '********',
                $number2,
                $number2 == $number,
//                length($number_string) >= PHP_FLOAT_DIG - 1,
//                length($number_string) >= (PHP_FLOAT_DIG - 1),
//                length($number_string) ,
//                PHP_FLOAT_DIG - 1,
//                PHP_FLOAT_DIG,
                '=======');

dump($numer_int != $number ,$sum <= PHP_FLOAT_DIG - 1, '///', $precision , $numer_int == $number);
            if (($number2 == $number && $numer_int != $number && $sum <= PHP_FLOAT_DIG - 1)) { //|| $number2 !== $number
//                (! $precision && $numer_int == $number) ||
                dump('OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO',$number);
                return true;
            }
        }
        dump('FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF',$number);

        return false;
    }
}
