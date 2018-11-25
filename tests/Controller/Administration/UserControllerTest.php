<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    /**
     * Test d'accès à la modification de son mot de passe lorsqu'on est idenfié
     * Test du changement de son mot de passe
     */
    public function testChangeUserPassword() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'doe.doe@mail.com',
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