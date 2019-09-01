<?php

declare(strict_types=1);


namespace Tests\Unit\Domain\ValueObject\Delivery;

use App\Domain\ValueObject\Delivery\DeliverySize;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class DeliverySizeTest extends TestCase
{
    public function testSuccessCreateSizeDataValueObject(): void
    {
        $expectedSize = '20';

        $date = DeliverySize::fromString($expectedSize);

        $this->assertInstanceOf(DeliverySize::class, $date);
        $this->assertSame(intval($expectedSize), $date->covers);
    }

    /** @dataProvider invalidSizeDataProvider */
    public function testFailureCreateSizeDataValueObject(string $invalidSize): void
    {
        $this->expectException(AssertionFailedException::class);

        DeliverySize::fromString($invalidSize);
    }

    public function invalidSizeDataProvider(): array
    {
        return [
            [''],
            ['1.1'],
            ['-99'],
            ['Not a number']
        ];
    }
}
