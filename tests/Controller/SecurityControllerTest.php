<?php

namespace App\Tests\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Tools\FakeUser;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    /**
     * @var null|Client
     */
    private $client = null;

    /**
     * @var FakeUser
     */
    private $fakeUser;

    /**
     * @throws \Exception
     */
    public function setUp() {
        $this->fakeUser = new FakeUser();
        $this->client = static::createClient();
    }

    public function testRouteAdministration() {

        $client = self::createClient();

        $crawler = $client->request('GET', '/administration');

        // Test du code retour
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test du contenu (bouton de connexion du formulaire)
        $this->assertSame(1, $crawler->filter('html:contains("login")')->count());
    }

    public function testLostPassword() {

        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');


        $link = $crawler
            ->selectLink("Mot de passe perdu ?")
            ->link();
        dump($link);

        $crawler = $client->click($link);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Email du mot de passe perdu")')->count());

//        $userRepository = $this->createMock(UserRepository::class);
//        $userRepository->expects($this->any())
//            ->method('findOneBy')
//            ->willReturn($this->fakeUser);
//
//        $objectManager = $this->createMock(ObjectManager::class);
//        $objectManager->expects($this->any())
//            ->method('getRepository')
//            ->willReturn($userRepository);
//
//        $form = $crawler->selectButton('login')->form();
//
//        $form['_username'] = 'exemple@mail.com';
//        $form['_password'] = 'complexePassword123';
//
//        $client->submit($form);
//
//        dump($crawler);
//
//        $crawler = $client->followRedirect();
//
//        // Test de la connexion (succès)
//        $this->assertSame(1, $crawler->filter('html:contains("dashboard")')->count());
    }

    /**
     * @throws \Exception
     */
    public function testLoginToAdministration() {

        $this->fakeUser->logIn();

        $crawler = $this->client->request('GET', '/administration/dashboard');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('dashboard', $crawler->filter('p')->text());
    }
}