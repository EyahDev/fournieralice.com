<?php


namespace App\Tests\Command;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserCommandTest extends KernelTestCase
{
    public function testExecute() {
        $kernel = static::createKernel();
        $application = new Application();

        $command = $application->find('app::user:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
           'command' => $command->getName()
        ]);
    }
}