<?php

declare(strict_types=1);

namespace App\Application\Command\Delivery\Specification;

use App\Domain\ValueObject\Delivery\DeliveryLocation;
use App\Domain\ValueObject\Delivery\DeliverySize;
use Assert\AssertionFailedException;

class DeliverySpecificationCommand
{
    public $size;
    public $location;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $size, string $postcode)
    {
        $this->size = DeliverySize::fromString($size);
        $this->location = DeliveryLocation::fromString($postcode);
    }
}