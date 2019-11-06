<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
     * @var SymfonyStyle
     */
    private $io;

    /**
     * UserCreateCommand constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $em
     */
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->encoder = $encoder;
        $this->em = $em;
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription("Créer un utilisateur et l'insère en base de données")
            ->addArgument('email', InputArgument::REQUIRED, "Email de l'utilisateur")
            ->addArgument('password', InputArgument::REQUIRED, "Mot de passe de l'utilisateur")
            ->addArgument('firstname', InputArgument::REQUIRED, "Prénom de l'utilisateur")
            ->addArgument('lastname', InputArgument::REQUIRED, "Nom de l'utilisateur")
            ->addArgument('phone', InputArgument::OPTIONAL, "Phone de l'utilisateur", '0601020304');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->io->title("Ajout d'un utilisateur");

        /* ARGUMENTS */
        $username = $input->getArgument('email');
        $password = $input->getArgument('password');
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $phone = $input->getArgument('phone');

        /* PROCESS */
        if (null !== $username) {
            $this->io->text(' > <info>Email de l\'utilisateur</info> : ' . $username);
        }

        if (null !== $password) {
            $this->io->text(' > <info>Mot de passe de l\'utilisateur</info> : '.str_repeat('*', mb_strlen($password)));
        }

        if (null !== $firstname) {
            $this->io->text(' > <info>Prénom de l\'utilisateur</info> : ' . $firstname);
        }

        if (null !== $lastname) {
            $this->io->text(' > <info>Nom de l\'utilisateur</info> : ' . $lastname);
        }

        if (null !== $phone) {
            $this->io->text(' > <info>Téléphone de l\'utilisateur</info> : '.$phone);
        }
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('email');
        $password = $input->getArgument('password');
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $phone = $input->getArgument('phone');

        $user = new User();
        $user->setEmail($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPhone($phone);

        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);

        $this->em->persist($user);
        $this->em->flush();

        $this->io->success("L'utilisateur $firstname $lastname a bien été créé");
    }
}
