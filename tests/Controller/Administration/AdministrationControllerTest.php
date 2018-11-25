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

class AdministrationControllerTest extends WebTestCase
{
    public function testRouteAdministrationDashboard() {

        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/dashboard');

        // Test du code HTTP
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Test du contenu (bouton de connexion du formulaire)
        $this->assertSame(1, $crawler->filter('html:contains("Dashboard")')->count());
    }
}