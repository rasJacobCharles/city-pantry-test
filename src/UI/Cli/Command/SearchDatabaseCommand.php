<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\Delivery\Date\DeliveryDateCommand;
use App\Application\Command\Delivery\DeliveryHandler;
use App\Application\Command\Delivery\Specification\DeliverySpecificationCommand;
use App\Infrastructure\Delivery\Exception\InvalidFilePathException;
use App\Infrastructure\Delivery\Query\Text\VendorRepository;
use Assert\AssertionFailedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchDatabaseCommand extends Command
{
    private const DEFAULT_INPUT_FILE = 'example-input';

    protected function configure(): void
    {
        $this
            ->setName('app:search-db')
            ->setDescription('Search Database for given menu items available given day')
            ->addArgument('day', InputArgument::REQUIRED, 'Date of order')
            ->addArgument('time', InputArgument::REQUIRED, 'Time of order')
            ->addArgument('location', InputArgument::REQUIRED, 'Location of order')
            ->addArgument('covers', InputArgument::REQUIRED, 'Number of people covered')
            ->addArgument('filename', InputArgument::OPTIONAL, 'Input file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $day = $input->getArgument('day');
        $time = $input->getArgument('time');
        $cover = $input->getArgument('covers');
        $location = $input->getArgument('location');
        $filename = $input->getArgument('filename') ? : self::DEFAULT_INPUT_FILE;

        try {
            $handler = new DeliveryHandler(
                new DeliveryDateCommand($day, $time),
                new DeliverySpecificationCommand($cover, $location),
                new VendorRepository($filename)
            );

            $output->writeln($handler());

        } catch (AssertionFailedException $exception) {
            $output->writeln(sprintf('Error Processing Command: %s', $exception->getMessage()));
        } catch (InvalidFilePathException $exception) {
            $output->writeln(sprintf('Error Processing Command: Unable to find file'));
        }

    }
}