<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'app:user:create';
    private $encoder;
    private $em;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
      $this->encoder = $encoder;
      $this->em = $em;
      parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Création d\' utilisateur');

        $username = $io->ask('Pseudonyme ?', null, function($username) {
            if(empty($username)) {
              throw new \RuntimeException('Le pseudonyme ne peut pas être vide.');
            }

            return $username;
        });

        $password = $io->askHidden('Mot de passe ?', function ($password) {
            if (empty($password)) {
                throw new \RuntimeException('Le mot de passe ne peut pas être vide.');
            }

            return $password;
        });

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password, $this->encoder);

        $this->em->persist($user);
        $this->em->flush();

        $io->success("La création de l'utilisateur $username est terminé !");
    }
}
