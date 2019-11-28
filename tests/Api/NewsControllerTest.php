<?php

namespace App\Tests\Api;

use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NewsControllerTest extends WebTestCase
{
    private $formData;

    private $testId;

    public function setUp(): void
    {
        $this->formData = [
            'title' => 'Unit test',
            'description' => '<p>Element créé pour les tests unitaires</p>',
        ];

        $this->testId = 3;
    }

    public function testGetNews()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);

        $client->request('GET', '/api/news');
        $news = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals(2, count($news));
    }

    public function testCreateNews()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);

        $client->request('POST', '/api/news', [], [], [], json_encode($this->formData));
        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals('News created successfully', $result);

        $client->request('GET', '/api/news');
        $news = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(3, count($news));
    }

    public function testEditNews()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);

        $data = [];
        $data['title'] = 'Edition test';
        $data['description'] = '<p>Le champ description a été édité</p>';

        $client->request('POST', "/api/news/$this->testId", [], [], [], json_encode($data));
        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals('News updated successfully', $result);
    }

    public function testEditNewsFail()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);

        $data = [];
        $data['title'] = null;
        $data['description'] = '';

        $client->request('POST', "/api/news/$this->testId", [], [], [], json_encode($data));
        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $client->getResponse()->getStatusCode());
    }

    public function testDeleteNews()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);

        $client->request('DELETE', "/api/news/$this->testId");
        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals('News deleted successfully', $result);
    }

}
