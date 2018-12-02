<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{

    /**
     * Test du changement de nom avec confirmation
     * Test du que le changement à bien été appliqué au formulaire
     */
    public function testChangeUserFirstName() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/user/informations');

        $form = $crawler->selectButton('Enregistrer')->form();

        $form['edit_informations[firstname]'] = 'NewFirstname';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Vos informations personnelles ont été mises à jour")')->count());

    }

    /**
     * Test du changement de nom avec confirmation
     */
    public function testChangeUserLastName()
    {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/user/informations');

        $form = $crawler->selectButton('Enregistrer')->form();

        $form['edit_informations[lastname]'] = 'NewLastname';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Vos informations personnelles ont été mises à jour")')->count());
    }

    /*
     * Test du changement de nom avec confirmation
     */
    public function testChangeUserPhone() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/user/informations');

        $form = $crawler->selectButton('Enregistrer')->form();

        $form['edit_informations[phone]'] = '0405060708';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Vos informations personnelles ont été mises à jour")')->count());
    }

    /**
     * Test d'accès à la modification des informations de l'utilisateurs lorsqu'on est identifié
     * Test du changement d'email
     * Test de de redirection vers la page de login
     */
    public function testChangeUserEmail() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/user/informations');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Vos informations")')->count());

        $form = $crawler->selectButton('Enregistrer')->form();

        $form['edit_informations[email]'] = 'john.doe@exemple.com';

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirection());

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("administration")')->count());
    }

    /**
     * Test d'accès à la modification de son mot de passe lorsqu'on est idenfié
     * Test du changement de son mot de passe
     */
    public function testChangeUserPassword() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@exemple.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/user/password');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Modification de votre mot de passe")')->count());

        $form = $crawler->selectButton('Enregistrer')->form();

        $form['change_password[oldPassword]'] = 'complexePassword123';
        $form['change_password[newPassword][first]'] = 'newComplexePassword123';
        $form['change_password[newPassword][second]'] = 'newComplexePassword123';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Votre mot de passe a été modifié")')->count());

    }

}