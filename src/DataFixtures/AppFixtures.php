<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Services\Utils\TokenGenerator;
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
        $this->loadUsers($manager);
    }

    /**
     * Jane Doe : Uniquement utitilisé pour la réinitialisation du mot de passe après oubli
     * John Doe : Utilisé pour la modification des informations personnelles
     * Harry Potter : Utilisé pour toutes les autres actions
     *
     * @return array
     */

    /**
     * @return array
     * @throws \Exception
     */
    private function getUserData()
    {
        return [
            // $userData = [$email, $password, $firstname, $lastname, $phone, $token, $validityToken];
            ['jane.doe@mail.com', 'complexePassword123', 'Jane', 'Doe', '0102030405', "b63339d02de3aa033866", null],
            ['john.doe@mail.com', 'complexePassword123', 'john', 'Doe', '0102030405', "b63339d02de3bb033866", new \DateTime('2018-11-01 10:00:00')],
            ['harry.potter@hogwarts.com', 'complexePassword123', 'Harry', 'Potter', '0102030405', null, null],
        ];
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadUsers(ObjectManager $manager) {
        foreach ($this->getUserData() as [$email, $password, $firstname, $lastname, $phone, $token, $validityToken]) {
            $user = new User();

            $user->setEmail($email);
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setPhone($phone);

            if ($token && !$validityToken) {
                $user->resetPasswordTokenProcess($token);
            } else {
                $user->setResetPasswordToken($token);
                $user->setResetPasswordTokenValidityDate($validityToken);
            }

            $manager->persist($user);
            $this->addReference($email, $user);
        }
        $manager->flush();
    }
}
