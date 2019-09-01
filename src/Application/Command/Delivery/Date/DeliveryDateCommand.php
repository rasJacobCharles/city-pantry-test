<?php

declare(strict_types=1);

namespace App\Application\Command\Delivery\Date;

use App\Domain\ValueObject\Delivery\DeliveryDay;
use App\Domain\ValueObject\Delivery\DeliveryTime;
use Assert\AssertionFailedException;

final class DeliveryDateCommand
{
    public $day;
    public $time;

    /** @throws AssertionFailedException */
    public function __construct(string $day, string $time)
    {
        $this->day = DeliveryDay::fromString($day);
        $this->time = !is_null($time)? DeliveryTime::fromString($time): null;
    }
}