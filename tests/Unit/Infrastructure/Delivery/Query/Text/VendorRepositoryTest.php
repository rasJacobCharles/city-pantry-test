<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Delivery\Query\Text;

use App\Application\Command\Delivery\Date\DeliveryDateCommand;
use App\Application\Command\Delivery\Specification\DeliverySpecificationCommand;
use App\Application\Query\Collection;
use App\Application\Query\Delivery\FindVendor;
use App\Infrastructure\Delivery\Exception\InvalidFilePathException;
use App\Infrastructure\Delivery\Query\Text\VendorRepository;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

class VendorRepositoryTest extends TestCase
{

    public function testSuccessFindMultipleByQuery(): void
    {
        $repository = new VendorRepository('example-input');
        $result = $repository->find(
            new FindVendor(
                new DeliveryDateCommand('21/12/19', '11:11'),
                new DeliverySpecificationCommand('3', 'NW43QB')
            )
        );

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(2, $result->count());
        $this->assertEquals('Premium meat selection;Breakfast;gluten,eggs', (string)$result);

    }

    public function testSuccessFindASingleResult(): void
    {
        $repository = new VendorRepository('example-input');
        $date = new DateTime();
        $date->add(new DateInterval(sprintf('PT13H')));

        $result = $repository->find(
            new FindVendor(
                new DeliveryDateCommand($date->format('d/m/y'), $date->format('h:s')),
                new DeliverySpecificationCommand('3', 'NW43QB')
            )
        );

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(1, $result->count());
        $this->assertEquals('Breakfast;gluten,eggs', (string)$result);

    }

    /**
     * @dataProvider failureFindRecordDateProvider
     */
    public function testFailureRecordNotFound(DeliveryDateCommand $dateCommand, DeliverySpecificationCommand $specificationCommand): void
    {
        $repository = new VendorRepository('example-input');

        $result = $repository->find(
            new FindVendor(
                $dateCommand,
                $specificationCommand
            )
        );

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(0, $result->count());
        $this->assertEquals('', (string)$result);

    }

    public function testFailureFileDoesNotExist(): void
    {
        $this->expectException(InvalidFilePathException::class);

        new VendorRepository('invalidfile');
    }

    public function failureFindRecordDateProvider(): array
    {
        return [
            [
                new DeliveryDateCommand('12/12/12', '11:11'),
                new DeliverySpecificationCommand('3', 'NW43QB')
            ],
            [
                new DeliveryDateCommand('12/12/22', '11:11'),
                new DeliverySpecificationCommand('99', 'NW43QB')
            ],
            [
                new DeliveryDateCommand('12/12/22', '11:11'),
                new DeliverySpecificationCommand('99', 'SW93QB')
            ],
        ];
    }
}
