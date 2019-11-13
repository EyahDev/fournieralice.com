<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    /**
     * Test de connexion à la page d'administration avec de bon identifiants
     * Test de connexion à la page d'administration avec de mauvais identifiants
     */
    public function testLogInToAdministration() {

        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = 'harry.potter@mail.com';
        $form['_password'] = 'complexePassword123';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Dashboard, bonjour")')->count());

        // -----------------------------
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');

        $form = $crawler->selectButton('login')->form();

        $form['_username'] = 'harry.potter@mail.com';
        $form['_password'] = 'wrongPassword123';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Identifiants invalides.")')->count());
    }

    /**
     * Test d'accès à la page de demande de réinitialisation de son mot de passe
     * Test de demande de réinitialisation de son mot de passe avec une adresse mail valide
     * Test de demande de réinitialisation de son mot de passe avec une adresse mail invalide
     *
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

        // -----------------------------
        $form = $crawler->selectButton('Envoyer')
            ->form(array('lost_password[email]' => 'harry.potter@mail.com'));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Un email de réinitialisation de mot de passe vous a été envoyé.")')->count());

        // -----------------------------
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
     * Test d'accès à la page de reset d'un mot de passe avec un token valide mais une date de validité échue
     * Test d'accès à la page de reset d'un mot de passe avec un token qui n'existe pas
     * Test d'accès à la page de reset d'un mot de passe avec un token valide
     * Test de réinitialisation du mot de passe
     * Test de login après avoir changer son mot de passe
     *
     * @throws \Exception
     */
    public function testResetPassword() {

        $client = static::createClient();

        $crawler = $client->request('GET', '/administration/password/reset/b63339d02de3bb033866');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ce lien, n\'est plus valide.")')->count());

        // -----------------------------
        $client = static::createClient();

        $client->request('GET', '/administration/password/reset/tokenDoNotExist');

        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        // -----------------------------
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration/password/reset/b63339d02de3aa033866');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Réinitilisation de votre mot de passe")')->count());

        // -----------------------------
        $form = $crawler->selectButton('Enregistrer')
            ->form(array(
                'reset_password[password][first]' => 'newComplexePassword123',
                'reset_password[password][second]' => 'newComplexePassword123',
            ));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("login")')->count());

        // -----------------------------
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'newComplexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/dashboard');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Dashboard, bonjour")')->count());

    }
}