<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    public function testRouteAdministration() {

        $client = self::createClient();

        $crawler = $client->request('GET', '/administration');

        // Test du code HTTP retour
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Test du contenu (bouton de connexion du formulaire)
        $this->assertSame(1, $crawler->filter('html:contains("login")')->count());
    }

//    public function testLogInToAdministration() {
//        /* Test de connexion avec de bon identifiants */
//        $client = self::createClient();
//
//        $crawler = $client->request('GET', '/administration');
//
//        $form = $crawler->selectButton('login')->form();
//
//        $form['_username'] = 'exemple@mail.com';
//        $form['_password'] = 'complexePassword123';
//
//        $crawler = $client->submit($form);
//        dump($client->getResponse());
//        dump($crawler);
//        // Test du contenu (titre de la page)
//        $this->assertSame(1, $crawler->filter('html:contains("dashboard")')->count());
//
//        /* Test de connexion avec de mauvais identifiants */
//        $client = self::createClient();
//
//        $crawler = $client->request('GET', '/administration');
//
//        // Formulaire (avec login incorrecte)
//        $form = $crawler->selectButton('login')->form();
//
//        $form['_username'] = 'exemple@mail.com';
//        $form['_password'] = 'wrongComplexePassword123';
//
//        $client->submit($form);
//
//        $crawler = $client->followRedirect();
//
//        // Test du contenu (message d'erreurs concernant les identifiants)
//        $this->assertSame(1, $crawler->filter('html:contains("Invalid credentials.")')->count());
//    }

//    public function testRouteAdministrationDashboard() {
//
//        $client = self::createClient(array(), array(
//            'PHP_AUTH_USER' => 'exemple@mail.com',
//            'PHP_AUTH_PW'   => 'complexePassword123',
//        ));
//
//        $crawler = $client->request('GET', '/administration/dashboard');
//
//        dump($client->getResponse());
//        // Test du code HTTP retour
//        $this->assertSame(200, $client->getResponse()->getStatusCode());
//
//        // Test du contenu (bouton de connexion du formulaire)
//        $this->assertSame(1, $crawler->filter('html:contains("dashboard")')->count());
//    }

    public function testLostPassword() {

        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');


        $link = $crawler
            ->selectLink("Mot de passe perdu ?")
            ->link();

        $crawler = $client->click($link);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Email du mot de passe perdu")')->count());
    }
}