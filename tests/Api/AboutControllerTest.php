<?php


namespace App\Tests\Api;


use App\Entity\About;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AboutControllerTest extends WebTestCase {

    public function testGetInitialAbout()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $client->request('GET', '/api/about');
        $content = json_decode($client->getResponse()->getContent(), true)['content'];
        $this->assertEquals('<h1>About section !</h1>', $content);

    }

    public function testPostAboutSection()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $client->request('POST', '/api/about', [], [], [], json_encode(['content' => '<p>Welcome to about section</p>']));
        $result = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('About section updated successfully', $result);

    }

    public function testAnyPostArguments()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $client->request('POST', '/api/about', [], [], [], null);
        $result = $client->getResponse()->getStatusCode();

        $this->assertEquals(500, $result);

    }

    public function testInvalidPostArguments()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $client->request('POST', '/api/about', [], [], [], json_encode(['api' => '<p>Welcome to about section</p>']));
        $result = $client->getResponse()->getStatusCode();
        $this->assertEquals(500, $result);

    }

    public function testGetAboutSectionAfterUpdate()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'john.doe@mail.com',
            'PHP_AUTH_PW'   => 'complexePassword123',
        ));

        $client->request('GET', '/api/about');
        $content = json_decode($client->getResponse()->getContent(), true)['content'];
        $this->assertEquals('<p>Welcome to about section</p>', $content);

    }

    public function testAboutObject(){
       $about = new About();
       $about->setContent('test');
       $about->setUpdated(new \DateTime());

       $this->assertEquals((new \DateTime())->format('dd/mm/YYYY'), $about->getUpdated()->format('dd/mm/YYYY'));
       $this->assertEquals('test', $about->getContent());
       
       $unserializedData = 'a:3:{i:0;N;i:1;s:10:"TTTTTTTTTT";i:2;O:8:"DateTime":3:{s:4:"date";s:26:"2019-11-21 13:34:26.990572";s:13:"timezone_type";i:3;s:8:"timezone";s:13:"Europe/Berlin";}}';
       $about->unserialize($unserializedData);

       $this->assertEquals($unserializedData, $about->serialize());

    }
}