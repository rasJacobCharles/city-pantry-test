<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Delivery;

use Assert\AssertionFailedException;
use Assert\Assertion;

class DeliveryTime
{
    private const TIME_PATTERN = '/^(0[0-9]|1[0-9]|2[0-3]|[0-9]):[0-5][0-9]$/';
    private const ERROR_MESSAGE = 'Error: Not a valid time.';

    public $time;

    private function __construct()
    {
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $time): DeliveryTime
    {
        Assertion::regex($time, self::TIME_PATTERN, self::ERROR_MESSAGE);

        $deliveryTime = new self();
        $deliveryTime->time = $time;

        return $deliveryTime;
    }
}