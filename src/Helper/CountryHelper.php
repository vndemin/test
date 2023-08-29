<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\Intl\Countries;

class CountryHelper
{
    public static function getCountriesCode(): array
    {
        $countriesLowerCase = array_map(
            static fn(string $elem) => strtolower($elem),
            Countries::getCountryCodes()
        );

        return array_merge($countriesLowerCase);
    }
}