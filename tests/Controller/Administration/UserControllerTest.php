<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 24/11/2018
 * Time: 23:36
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    public function testChangeUserPassword() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/user/password');

        // Test du code HTTP
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Test du contenu (formulaire pour le changement de mot de passe)
        $this->assertSame(1, $crawler->filter('html:contains("Modification de votre mot de passe")')->count());

        // Test de changement de mot de passe
        $form = $crawler->selectButton('Enregistrer')->form();

        $form['change_password[oldPassword]'] = 'complexePassword123';
        $form['change_password[newPassword][first]'] = 'newComplexePassword123';
        $form['change_password[newPassword][second]'] = 'newComplexePassword123';

        $client->submit($form);
        dump($client);
        $this->assertSame(1, $crawler->filter('html:contains("Invalid credentials.")')->count());

    }
}