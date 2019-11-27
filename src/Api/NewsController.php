<?php

namespace App\Api;

use App\Entity\News;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class NewsController extends AbstractFOSRestController  {

    /**
     * @Rest\Get("/news", name="api_news_index", methods={"GET"})
     */
    public function getNews()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findAll();

        return View::create($news, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/news", name="api_news_create", methods={"POST"})
     */
    public function createNews(Request $request): View
    {
        $data = json_decode($request->getContent(), true);
        if(empty($data) || !isset($data['title']) || is_null($data['title']) ||
          !isset($data['description']) || is_null($data['description'])) {
            throw new \InvalidArgumentException("Invalid argument or argument content doesn't exist");
        }

        $news = new News();
        $news->setTitle($data['title']);
        $news->setDescription($data['description']);
        $news->setAuthor($this->getUser());
        $news->setPublicationDate(new \DateTime());
        $this->getDoctrine()->getRepository(News::class)->save($news);

        return View::create('News created successfully', Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/news/{id}", name="api_news_update", methods={"POST"})
     */
    public function updateNews(int $id, Request $request): View
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findOneById($id);
        if(!$news) {
            throw new \InvalidArgumentException("News to update not found");
        }

        $data = json_decode($request->getContent(), true);
        if(empty($data) || !isset($data['title']) || is_null($data['title']) ||
          !isset($data['description']) || is_null($data['description'])) {
            throw new \InvalidArgumentException("Invalid argument or argument content doesn't exist");
        }

        $news->setTitle($data['title']);
        $news->setDescription($data['description']);

        if(isset($data['archived']) && !is_null($data['archived'])) {
            $news->setArchived($data['archived']);
        }
        else {
            $news->setLastEditDate(new \DateTime());
        }

        $this->getDoctrine()->getRepository(News::class)->save($news);

        return View::create('News updated successfully', Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/news/{id}", name="api_news_delete", methods={"DELETE"})
     */
    public function deleteNews(int $id): View
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findOneById($id);
        if(!$news) {
            throw new \InvalidArgumentException("News to delete not found");
        }

        $this->getDoctrine()->getRepository(News::class)->delete($news);

        return View::create('News deleted successfully', Response::HTTP_OK);
    }
}
