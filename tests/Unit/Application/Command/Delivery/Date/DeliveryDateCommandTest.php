<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Command\Delivery\Date;

use App\Application\Command\Delivery\Date\DeliveryDateCommand;
use App\Domain\ValueObject\Delivery\DeliveryDay;
use App\Domain\ValueObject\Delivery\DeliveryTime;
use Assert\AssertionFailedException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DeliveryDateCommandTest extends TestCase
{
    public function testsSuccessCreateDateCommand(): void
    {
        $expectedDate = '12/12/19';
        $expectedTime = '12:12';

        $command = new DeliveryDateCommand($expectedDate, $expectedTime);
        $this->assertInstanceOf(DeliveryDay::class, $command->day);
        $this->assertInstanceOf(DeliveryTime::class, $command->time);
        $this->assertSame($expectedDate, $command->day->date);
        $this->assertSame($expectedTime, $command->time->time);
    }

    /**
     * @dataProvider invalidImportDataProvider
     */
    public function testsFailureCreateDateCommandWithInvalidInput(string $invalidDate, string $invalidTime): void
    {
        $this->expectException(AssertionFailedException::class);

        new DeliveryDateCommand($invalidDate, $invalidTime);
    }

    public function invalidImportDataProvider(): array
    {
        return [
            ['12/12/2012', ''],
            ['', '12:12'],
            ['12/12/2012', 'not a time'],
            ['not a date', '12:12'],
        ];
    }
}
