<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Delivery;

use Assert\Assertion;
use Assert\AssertionFailedException;

class DeliverySize
{
    private const SIZE_PATTERN = '/^[0-9]*$/';
    public $covers;

    private function __construct()
    {
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $size): DeliverySize
    {
        Assertion::regex($size, self::SIZE_PATTERN);
        Assertion::true((int) $size > 0);

        $deliverySize = new self();
        $deliverySize->covers = (int) $size;

        return $deliverySize;
    }
}