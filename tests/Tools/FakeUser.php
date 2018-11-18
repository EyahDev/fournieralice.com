<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 18/11/2018
 * Time: 10:32
 */

namespace App\Tests\Tools;


use App\Entity\User;
use App\Services\Utils\TokenGeneratorService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class FakeUser extends WebTestCase
{
    /**
     * @return User
     * @throws \Exception
     */
    public function values() {
        self::bootKernel();

        $container = self::$kernel->getContainer();

        $encoder = self::$container->get('security.password_encoder');

        $tokenGenerator = new TokenGeneratorService();

        $fakeUser = new User();
        $fakeUser->setUsername('exemple@mail.com');
        $fakeUser->setPassword('complexePassword123', $encoder);
        $fakeUser->setFirstname('Jane');
        $fakeUser->setLastname('Doe');
        $fakeUser->setPhone('0102030405');
        $fakeUser->setResetPasswordToken($tokenGenerator->generateRandomToken(10));
        $fakeUser->setResetPasswordTokenValidityDate(new \DateTime());

        return $fakeUser;
    }

    /**
     * @throws \Exception
     */
    public function logIn()
    {
        $client = static::createClient();

        $session = $client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $token = new UsernamePasswordToken($this->values()->getUsername(), null, $firewallName, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }
}