<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command\Delivery\Specification;

use App\Application\Command\Delivery\Specification\DeliverySpecificationCommand;
use App\Domain\ValueObject\Delivery\DeliveryLocation;
use App\Domain\ValueObject\Delivery\DeliverySize;
use Assert\AssertionFailedException;
use PHPUnit\Framework\TestCase;

class DeliverySpecificationCommandTest extends TestCase
{
    public function testsSuccessCreateDateCommandWithBothDateAndTime():void
    {
        $expectedSize = 2;
        $expectedPostCode = 'NW43QB';

        $command = new DeliverySpecificationCommand("2", $expectedPostCode);
        $this->assertInstanceOf(DeliverySize::class, $command->size);
        $this->assertInstanceOf(DeliveryLocation::class, $command->location);
        $this->assertSame($expectedSize, $command->size->covers);
        $this->assertSame($expectedPostCode, $command->location->postCode);
    }

    /**
     * @dataProvider invalidImportDataProvider
     */
    public function testsFailureCreateDateCommandWithInvalidInput(string $invalidSize, string $invalidPostCode): void
    {
        $this->expectException(AssertionFailedException::class);

        new DeliverySpecificationCommand($invalidSize, $invalidPostCode);
    }

    public function invalidImportDataProvider(): array
    {
        return [
            ['3', ''],
            ['', 'NW43QB'],
        ];
    }
}
