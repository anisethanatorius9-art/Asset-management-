<?php

namespace App\Helpers;

use Flux\Flux;

class helper
{
    private static function fluxToast(string $message, string $type, string $heading): void
    {
       Flux::toast(
        heading: $heading,
        text: $message,
        variant: $type,
       );
    }
    public static function successToast(string $message, string $heading = 'Success'): void
    {
        self::fluxToast('success', $message,  $heading );
    }
    public static function errorToast(string $message, string $heading = 'Error'): void
    {
        self::fluxToast('danger', $message,  $heading );
    }

    /**
     * Format large numbers with abbreviations (1k, 1M, 1B, 1T).
     *
     * @param int|float $number
     * @param int $decimals
     * @return string
     */
    public static function formatNumber(int|float $number, int $decimals = 1): string
    {
        if ($number == 0) {
            return '0';
        }

        $abbreviations = [
            1_000_000_000_000 => 'T', // Trillion
            1_000_000_000 => 'B',     // Billion
            1_000_000 => 'M',         // Million
            1_000 => 'k',             // Thousand
        ];

        $abs_number = abs($number);

        foreach ($abbreviations as $divisor => $abbreviation) {
            if ($abs_number >= $divisor) {
                $formatted = round($number / $divisor, $decimals);
                // Remove trailing zeros after decimal point
                $formatted = rtrim(rtrim((string)$formatted, '0'), '.');
                return $formatted . $abbreviation;
            }
        }

        return number_format($number);
    }


}

