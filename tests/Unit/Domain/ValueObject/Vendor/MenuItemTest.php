<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject\Vendor;

use App\Domain\ValueObject\Vendor\MenuItem;
use App\Infrastructure\Delivery\Exception\AdvanceTimeException;
use PHPUnit\Framework\TestCase;

class MenuItemTest extends TestCase
{
    public function testSuccessRestaurant(): void
    {
        $menuItem = new MenuItem('test', 'test 1', '12h');

        $this->assertEquals('test;test 1', (string) $menuItem);
    }

    public function testFailureInvalidPrepareTime(): void
    {
        $this->expectException(AdvanceTimeException::class);
        new MenuItem('test', 'test 1', '12');

    }
}
