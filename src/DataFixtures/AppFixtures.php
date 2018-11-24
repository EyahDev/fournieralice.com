<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Services\Utils\TokenGeneratorService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        // Création d'un utilisateur fictif

        $user = new User();
        $user->setUsername('exemple@mail.com');
        $user->setPassword('complexePassword123', $this->encoder);
        $user->setFirstname('Jane');
        $user->setLastname('Doe');
        $user->setPhone('0102030405');

        $tokenGenerator = new TokenGeneratorService();

        $user->setResetPasswordToken($tokenGenerator->generateRandomToken(10));
        $user->setResetPasswordTokenValidityDate(new \DateTime());

        $manager->persist($user);
        $manager->flush();
    }
}
