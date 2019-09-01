<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Delivery;

use Assert\Assertion;
use Assert\AssertionFailedException;

class DeliveryLocation
{
    private const ERROR_MESSAGE = 'Invalid post code';
    private const POST_PATTERN = '/\b((?:(?:gir)|(?:[a-pr-uwyz])(?:(?:[0-9](?:[a-hjkpstuw]|[0-9])?)|(?:[a-hk-y][0-9](?:[0-9]|[abehmnprv-y])?)))) ?([0-9][abd-hjlnp-uw-z]{2})\b/i';

    public $postCode;

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $postcode): DeliveryLocation
    {
        Assertion::regex($postcode, self::POST_PATTERN, self::ERROR_MESSAGE);

        $deliveryLocation = new self();
        $deliveryLocation->postCode = $postcode;

        return $deliveryLocation;
    }
}