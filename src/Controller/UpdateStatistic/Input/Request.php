<?php

declare(strict_types=1);

namespace App\Controller\UpdateStatistic\Input;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class Request
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Helper\CountryHelper", "getCountriesCode"})
     *
     * @Serializer\Type("string")
     */
    public string $countryCode;
}