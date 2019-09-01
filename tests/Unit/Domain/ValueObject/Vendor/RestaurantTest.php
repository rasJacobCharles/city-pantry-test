<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject\Vendor;

use App\Domain\ValueObject\Vendor\MenuItem;
use App\Domain\ValueObject\Vendor\Restaurant;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RestaurantTest extends TestCase
{
    public function testSuccessRestaurant(): void
    {
        /** @var MockObject| MenuItem $expectedItem */
        $expectedItem = $this->createMock(MenuItem::class);
        $restaurant = new Restaurant();

        $restaurant->add($expectedItem);
        $restaurant->add($expectedItem);
        $restaurant->add($expectedItem);
        $restaurant->add($expectedItem);
        $restaurant->add($expectedItem);

        $this->assertEquals(1, count($restaurant->getMenu()));
    }
}
