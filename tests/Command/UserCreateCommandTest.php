<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 09/02/2019
 * Time: 16:18
 */

namespace App\Tests\Command;

use App\Command\UserCreateCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;


class UserCreateCommandTest extends KernelTestCase
{
    public function testCommand()
    {
        echo 'BEFORE';
        $kernel = $this->createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');
        $encoder = $container->get('security.password_encoder');

        $application = new Application($kernel);
        $application->add(new UserCreateCommand($encoder, $em));

        $command = $application->find('app:user:create');

        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['Test', '1234']);
        //$commandTester->setInputs(['Test', '1234']);
        $commandTester->execute([
            'command'  => $command->getName()
        ]);

        $output = $commandTester->getDisplay();

        echo 'AFTER';
       $this->assertContains('Username: Wouter', 'bite');
    }
}