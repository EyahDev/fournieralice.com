<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Services\Utils\TimeSetter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testRouteAdministration() {

        $client = self::createClient();

        $crawler = $client->request('GET', '/administration');

        // Test du code HTTP
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Test du contenu (bouton de connexion du formulaire)
        $this->assertSame(1, $crawler->filter('html:contains("login")')->count());
    }

    public function testLogInToAdministration() {
        /* Test de connexion avec de bon identifiants */
        $client = self::createClient();

        $crawler = $client->request('GET', '/administration');

        $form = $crawler->selectButton('login')->form();

        $form['_username'] = 'jane.doe@mail.com';
        $form['_password'] = 'complexePassword123';

        $crawler = $client->submit($form);

        // Test du contenu (titre de la page)
        $this->assertSame(1, $crawler->filter('html:contains("dashboard")')->count());

        /* Test de connexion avec de mauvais identifiants */
        $client = self::createClient();

        $crawler = $client->request('GET', '/administration');

        $form = $crawler->selectButton('login')->form();

        $form['_username'] = 'jane.doe@mail.com';
        $form['_password'] = 'wrongComplexePassword123';

        $client->submit($form);

        $crawler = $client->followRedirect();

        // Test du contenu (message d'erreurs concernant les identifiants)
        $this->assertSame(1, $crawler->filter('html:contains("Invalid credentials.")')->count());
    }

    public function testRouteAdministrationDashboard() {

        $client = self::createClient(array(), array(
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/dashboard');

        // Test du code HTTP
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Test du contenu (bouton de connexion du formulaire)
        $this->assertSame(1, $crawler->filter('html:contains("Dashboard")')->count());
    }

    /**
     * @throws \Exception
     */
    public function testLostPassword() {
        /* Test avec un email valide */

        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');

        $link = $crawler
            ->selectLink("Mot de passe perdu ?")
            ->link();

        $crawler = $client->click($link);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Email du mot de passe perdu")')->count());

        $form = $crawler->selectButton('Envoyer')
            ->form(array('lost_password[email]' => 'jane.doe@mail.com'));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Un email de réinitialisation de mot de passe vous a été envoyé.")')->count());

        /* Test avec un email non valide */

        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');

        $link = $crawler
            ->selectLink("Mot de passe perdu ?")
            ->link();

        $crawler = $client->click($link);

        $form = $crawler->selectButton('Envoyer')
            ->form(array('lost_password[email]' => 'wrong@mail.com'));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Cet email n\'existe pas.")')->count());
    }

    /**
     * @throws \Exception
     */
    public function testResetPassword() {
        /* Test avec un token valide mais avec un temps de validité écoulé */
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration/password/reset/b63339d02de3bb033866');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ce lien, n\'est plus valide.")')->count());

        /* Test avec un token invalide */
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration/password/reset/b63339d02de3cc033866');

        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        $client = static::createClient();

        $crawler = $client->request('GET', '/administration/password/reset/b63339d02de3aa033866');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Réinitilisation de votre mot de passe")')->count());

//        $form = $crawler->selectButton('Envoyer')
//            ->form(array('lost_password[email]' => 'exemple@mail.com'));
//
//        $client->submit($form);
//
//        $crawler = $client->followRedirect();
//
//        $this->assertSame(1, $crawler->filter('html:contains("Un email de réinitialisation de mot de passe vous a été envoyé.")')->count());
//
//        /* Test avec un email non valide */
//
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/administration');
//
//        $link = $crawler
//            ->selectLink("Mot de passe perdu ?")
//            ->link();
//
//        $crawler = $client->click($link);
//
//        $form = $crawler->selectButton('Envoyer')
//            ->form(array('lost_password[email]' => 'wrong@mail.com'));
//
//        $client->submit($form);
//
//        $crawler = $client->followRedirect();
//
//        $this->assertSame(1, $crawler->filter('html:contains("Cet email n\'existe pas.")')->count());
    }
}