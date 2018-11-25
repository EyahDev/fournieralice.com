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
        // Création d'utilisateurs fictifs
        $fakeUsers = [['username' => 'jane.doe@mail.com',
                'password' => 'complexePassword123',
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'phone' => '0102030405',
                'token' => 'b63339d02de3aa033866',
                'tokenDate' => null
            ], ['username' => 'john.doe@mail.com',
                'password' => 'complexePassword123',
                'firstname' => 'John',
                'lastname' => 'Doe',
                'phone' => '0102030405',
                'token' => 'b63339d02de3bb033866',
                'tokenDate' => new \DateTime('2018-11-01 10:00:00')
            ], ['username' => 'doe.doe@mail.com',
                'password' => 'complexePassword123',
                'firstname' => 'Doe',
                'lastname' => 'Doe',
                'phone' => '0102030405',
                'token' => 'b63339d02de3cc033866',
                'tokenDate' => null]
        ];

        foreach ($fakeUsers as $fakeUser) {
            $user = new User();

            $password = $this->encoder->encodePassword($user, $fakeUser['password']);

            $user->setUsername($fakeUser['username']);
            $user->setPassword($password);
            $user->setFirstname($fakeUser['firstname']);
            $user->setLastname($fakeUser['lastname']);
            $user->setPhone($fakeUser['phone']);

            if (!$fakeUser['tokenDate']) {
                $user->resetPasswordTokenProcess($fakeUser['token']);
            } else {
                $user->setResetPasswordToken($fakeUser['token']);
                $user->setResetPasswordTokenValidityDate($fakeUser['tokenDate']);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}
