<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Query\Delivery;

use App\Application\Command\Delivery\Date\DeliveryDateCommand;
use App\Application\Command\Delivery\Specification\DeliverySpecificationCommand;
use App\Application\Query\Delivery\FindVendor;
use DateTime;
use PHPUnit\Framework\TestCase;

class FindVendorTest extends TestCase
{
    public function testSuccessCreateQuery(): void
    {
        $query = new FindVendor(
            new DeliveryDateCommand('01/12/22', '12:22'),
            new DeliverySpecificationCommand('3', 'NW43QB')
        );

        $this->assertEquals(3, $query->covers);
        $this->assertEquals('NW', $query->location);
        $this->assertInstanceOf(DateTime::class, $query->date);
        $this->assertEquals('01/12/22 12:12', $query->date->format('d/m/y h:m'));
    }
}
