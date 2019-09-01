<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject\Delivery;

use App\Domain\ValueObject\Delivery\DeliveryLocation;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class DeliveryLocationTest extends TestCase
{
    public function testSuccessCreateSizeDataValueObject(): void
    {
        $expectedPostCode = 'NW43QB';

        $location = DeliveryLocation::fromString($expectedPostCode);

        $this->assertInstanceOf(DeliveryLocation::class, $location);
        $this->assertSame($expectedPostCode, $location->postCode);
    }

    /** @dataProvider invalidSizeDataProvider */
    public function testFailureCreateSizeDataValueObject(string $invalidPostCode): void
    {
        $this->expectException(AssertionFailedException::class);

        DeliveryLocation::fromString($invalidPostCode);
    }

    public function invalidSizeDataProvider(): array
    {
        return [
            [''],
            ['1.1'],
            ['eee'],
        ];
    }
}
