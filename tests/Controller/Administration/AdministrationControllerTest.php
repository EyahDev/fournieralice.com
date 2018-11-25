<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdministrationControllerTest extends WebTestCase
{
    /**
     * Test d'accès au dashboard lorsqu'on est identifié
     */
    public function testRouteAdministrationDashboard() {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $crawler = $client->request('GET', '/administration/dashboard');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Dashboard, bonjour")')->count());
    }
}