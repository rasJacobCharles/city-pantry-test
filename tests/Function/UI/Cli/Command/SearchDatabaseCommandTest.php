<?php

declare(strict_types=1);

namespace Tests\Functional\UI\Cli\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserCommandTest extends KernelTestCase
{
    public function testSuccessExecute(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:search-db');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command'  => $command->getName(),
                'day' => '14/11/22',
                'time' => '11:00',
                'location'=>'NW43QB',
                'covers' => '20'
            ]
        );

        $output = $commandTester->getDisplay();
        $this->assertContains('Premium meat selection;Breakfast;gluten,eggs', $output);
    }

    public function testFailureExecuteInvalidArgument(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:search-db');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command'  => $command->getName(),
                'day' => 'not a date',
                'time' => '1100',
                'location'=>'E32NY',
                'covers' => 'nine',
                'filename' => 'invalid-input'
            ]
        );

        $output = $commandTester->getDisplay();
        $this->assertContains(
            'Error Processing Command: Date "not a date" is invalid or does not match format "d/m/y',
            $output
        );
    }

    public function testFailureExecuteFileDoesNotExist(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:search-db');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command'  => $command->getName(),
                'day' => '14/11/22',
                'time' => '11:00',
                'location'=>'NW43QB',
                'covers' => '20',
                'filename' => 'error'
            ]
        );

        $output = $commandTester->getDisplay();
        $this->assertContains('Error Processing Command: Unable to find file', $output);
    }
}
