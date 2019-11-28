<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 24/11/2018
 * Time: 23:34
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PortfolioControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        // Test du code HTTP
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Test du contenu (bouton de connexion du formulaire)
        $this->assertSame(1, $crawler->filter('html:contains("Homepage")')->count());
    }

    public function testNewspage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testHomeDetailpage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news/1');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
