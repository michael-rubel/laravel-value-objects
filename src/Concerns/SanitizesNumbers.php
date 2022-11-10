<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Concerns;

trait SanitizesNumbers
{
    /**
     * @param  int|string|null  $number
     *
     * @return string
     */
    public function sanitize(int|string|null $number): string
    {
        $number = str($number)->replace(',', '.');

        $dots = $number->substrCount('.');

        if (1 < $dots) {
            $number = $number
                ->replaceLast('.', ',')
                ->replace('.', '')
                ->replaceLast(',', '.');
        }

        return $number
            ->replaceMatches('/[^0-9.]/', '')
            ->toString();
    }
}
