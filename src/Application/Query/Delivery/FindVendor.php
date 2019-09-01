<?php

declare(strict_types=1);

namespace App\Application\Query\Delivery;

use App\Application\Command\Delivery\Date\DeliveryDateCommand;
use App\Application\Command\Delivery\Specification\DeliverySpecificationCommand;
use DateTime;

class FindVendor implements QueryInterface
{
    public $date;
    public $location;
    public $covers;

    public function __construct(DeliveryDateCommand $dateCommand, DeliverySpecificationCommand $specificationCommand)
    {
        $date = explode('/',  $dateCommand->day->date);
        $this->date = new DateTime(
            sprintf(
                '%s %s:00',
                implode('-', [$date[2],$date[1], $date[0]]),
                $dateCommand->time->time
            )
        );

        $this->location = strtoupper(substr($specificationCommand->location->postCode, 0, 2));
        $this->covers = $specificationCommand->size->covers;
    }
}