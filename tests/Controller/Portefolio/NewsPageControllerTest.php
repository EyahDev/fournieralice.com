<?php

namespace App\Tests\Controller;

use App\Form\Type\News\NewsType;
use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NewsPageControllerTest extends WebTestCase
{

    public function testGetSingleNews()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news/1');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testGetNews()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/news');

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

}
