<?php

namespace App\Tests\Controller;

use App\Form\Type\News\NewsType;
use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class NewsControllerTest extends WebTestCase
{
    private $formData;

    public function SetUp(){
        $this->formData = [
            'title' => 'Unit test',
            'description' => 'Element créé pour les tests unitaires',
        ];
    }

    public function testCreateNews()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);
        $crawler = $client->request('GET', '/administration/news/create');

        $this->assertStatusCode(Response::HTTP_OK, $client);

        $client->followRedirects();

        $form = $crawler->selectButton('Envoyer')->form();
        $form->setValues(array("news" => $this->formData));
        $client->submit($form);

        $this->assertStatusCode(Response::HTTP_OK, $client);
        $this->assertContains('Unit test', $client->getResponse()->getContent());
    }

    public function testEditNews()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);
        $crawler = $client->request('GET', '/administration/news/3/edit');

        $this->assertStatusCode(Response::HTTP_OK, $client);

        $client->followRedirects();

        $form = $crawler->selectButton('Envoyer')->form();
        $this->formData['title'] = 'Edition test';
        $this->formData['description'] = 'Le champ description a été édité';
        $form->setValues(array("news" => $this->formData));
        $client->submit($form);

        $this->assertStatusCode(Response::HTTP_OK, $client);
        $this->assertContains('Edition test', $client->getResponse()->getContent());
    }

    public function testDeleteNews()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'jane.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ]);

        $crawler = $client->request('DELETE', '/administration/news/3/delete');
        $client->followRedirects();

        $this->assertStatusCode(Response::HTTP_FOUND, $client);
        $this->assertNotContains('Edition test', $client->getResponse()->getContent());
    }

    private function assertStatusCode(int $code, $client)
    {
        $this->assertSame($code, $client->getResponse()->getStatusCode());
    }
}
