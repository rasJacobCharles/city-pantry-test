<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Delivery;

use Assert\Assertion;
use Assert\AssertionFailedException;

class DeliveryDay
{
    public $date;

    private function __construct()
    {
    }

    /** @throws AssertionFailedException */
    public static function fromString(string $dateString): DeliveryDay
    {
        Assertion::date($dateString, 'd/m/y');
        $date = new self();
        $date->date = $dateString;

        return $date;
    }
}