<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdministrationControllerTest extends WebTestCase
{
    /**
     * Test d'accès à la page d'administration
     * Test d'accès à la page d'administration lorsqu'on est déjà identifié
     */
    public function testRouteAdministration() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/administration');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("login")')->count());

        // -----------------------------
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'harry.potter@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $client->request('GET', '/administration');
        $crawler = $client->followRedirect();

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Dashboard, bonjour")')->count());
    }
}