<?php

declare(strict_types=1);


namespace App\Application\Command\Delivery;


use App\Application\Command\Delivery\Date\DeliveryDateCommand;
use App\Application\Command\Delivery\Specification\DeliverySpecificationCommand;
use App\Application\Query\Delivery\FindVendor;
use App\Infrastructure\Delivery\Query\Text\VendorRepository;

class DeliveryHandler
{
    private $query;
    private $repository;

    public function __construct(
        DeliveryDateCommand $dateCommand,
        DeliverySpecificationCommand $specificationCommand,
        VendorRepository $repository
    )
    {
        $this->query = new FindVendor(
            $dateCommand,
            $specificationCommand
        );

        $this->repository = $repository;
    }

    public function __invoke(): string
    {
        return (string) $this->repository->find($this->query);
    }
}