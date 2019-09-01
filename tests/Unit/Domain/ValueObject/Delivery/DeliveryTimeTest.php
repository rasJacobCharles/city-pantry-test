<?php

declare(strict_types=1);


namespace Tests\Unit\Domain\ValueObject\Delivery;

use App\Domain\ValueObject\Delivery\DeliveryTime;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class DeliveryTimeTest extends TestCase
{
    public function testSuccessCreateTimeDataValueObject(): void
    {
        $expectedTime = '12:12';

        $time = DeliveryTime::fromString($expectedTime);

        $this->assertInstanceOf(DeliveryTime::class, $time);
        $this->assertSame($expectedTime, $time->time);

    }

    public function testFailureCreateTimeDataValueObjectInvalidTime(): void
    {
        $expectedTime = '90:90';

        $this->expectException(AssertionFailedException::class);

        DeliveryTime::fromString($expectedTime);

    }
}
