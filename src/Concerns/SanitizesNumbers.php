<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Concerns;

trait SanitizesNumbers
{
    /**
     * @param float|int|string|null $number
     *
     * @return string
     */
    protected function sanitize(float|int|string|null $number): string
    {
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
}
