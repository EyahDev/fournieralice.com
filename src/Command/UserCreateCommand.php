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
    /**
     * @var string
     */
    protected static $defaultName = 'app:user:create';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserCreateCommand constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $em
     */
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
      $this->encoder = $encoder;
      $this->em = $em;
      parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Création d\'un utilisateur');

        $username = $io->ask('Adresse mail de l\'utilisateur', null, function($username) {
            if(empty($username)) {
              throw new \RuntimeException('Il faut obligatoirement une adresse mail !');
            }

            return $username;
        });

        $firstname = $io->ask('Prénom de l\'utilisateur', null, function($firstname) {
            if(empty($firstname)) {
                throw new \RuntimeException('Il faut obligatoirement une adresse mail !');
            }

            return $firstname;
        });

        $lastname = $io->ask('Nom de l\'utilisateur', null, function($lastname) {
            if(empty($lastname)) {
                throw new \RuntimeException('Il faut obligatoirement une adresse mail !');
            }

            return $lastname;
        });

        $phone = $io->ask('Téléphone de l\'utilisateur', "0601020304", function($phone) {
            return $phone;
        });

        $password = $io->askHidden('Mot de passe de l\'utilisateur', function ($password) {
            if (empty($password)) {
                throw new \RuntimeException('Il faut obligatoirement un mot de passe !');
            }

            return $password;
        });

        $user = new User();
        $user->setEmail($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPhone($phone);

        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        $this->em->persist($user);
        $this->em->flush();

        $io->success("L'utilisateur $firstname $lastname a bien été créé");
    }
}
