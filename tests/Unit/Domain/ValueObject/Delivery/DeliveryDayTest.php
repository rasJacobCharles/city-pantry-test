<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject\Delivery;

use App\Domain\ValueObject\Delivery\DeliveryDay;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class DeliveryDayTest extends TestCase
{
    public function testSuccessCreateDayDataValueObject(): void
    {
        $expectedDate = '12/12/19';

        $date = DeliveryDay::fromString($expectedDate);

        $this->assertInstanceOf(DeliveryDay::class, $date);
        $this->assertSame($expectedDate, $date->date);
    }

    /**
     * @dataProvider invalidDateDataProvider
     */
    public function testFailureCreateTimeDayValueObjectInvalidTime(string $invalidDate): void
    {
        $this->expectException(AssertionFailedException::class);

        DeliveryDay::fromString($invalidDate);

    }

    public function invalidDateDataProvider(): array
    {
        return [
            [''],
            ['2019/12/12'],
            ['12/29/2019']
        ];
    }
}
