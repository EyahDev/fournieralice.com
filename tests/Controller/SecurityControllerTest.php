<?php

namespace App\Tests\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Tools\FakeUser;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\Self_;
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

    public function testRouteHomePage() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        // Test du code retour
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test du contenu (accès à l'administration)
        $this->assertSame(1, $crawler->filter('html:contains("Administration")')->count());
    }

    public function testRouteAdministration() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');

        // Test du code retour
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test du contenu (bouton de connexion du formulaire)
        $this->assertSame(1, $crawler->filter('html:contains("login")')->count());
    }

    /**
     * @throws \Exception
     */
    public function testLostPassword() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');

        $link = $crawler
            ->selectLink("Mot de passe perdu ?")
            ->link();

        $crawler = $client->click($link);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Email du mot de passe perdu")')->count());

//        $form = $crawler->selectButton('Envoyer')->form(array('lost_password[email]' => 'exemple@mail.com'));
//
//        $client->submit($form);
    }

    /**
     * @throws \Exception
     */
    public function testLoginToAdministration() {
        $client = static::createClient();

        $this->fakeUser->logIn($client);

        $crawler = $client->request('GET', '/administration/dashboard');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame('Dashboard', $crawler->filter('p')->text());
    }
}