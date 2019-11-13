<?php


namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserCommandTest extends KernelTestCase
{
    /**
     * Test de la création d'un utilisateur avec la commande
     */
    public function testExecute() {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:user:create');

        $commandTesterWithoutError = new CommandTester($command);

        $commandTesterWithoutError->execute([
           'command' => $command->getName(),
            'email' => 'mail@mail.com',
            'password' => 'PasswordComplexe',
            'firstname' => 'Harry',
            'lastname' => 'Potter',
            'phone' => '0601020304'
        ]);

        $this->assertContains("[OK] L'utilisateur Harry Potter a bien été créé", $commandTesterWithoutError->getDisplay());
    }
}