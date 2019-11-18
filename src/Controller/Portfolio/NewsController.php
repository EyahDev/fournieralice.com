<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;
use App\Entity\News;

class NewsController extends AbstractController
{
    private $repository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->repository = $newsRepository;
    }

    /**
     * @Route("/news", name="news", methods={"GET"})
     */
    public function getNews()
    {
        $news = $this->repository->findAll();

        return $this->render('portfolio/news/news.html.twig', [
            'news_list' => $news,
        ]);
    }

    /**
     * @Route("/news/{id}", name="news_single_get", methods={"GET"})
     */
    public function getSingleNews(int $id)
    {
        $news = $this->repository->findOneById($id);
        if(!$news) {
            $response = new Response('', Response::HTTP_NOT_FOUND);
            $response->send();
        }

        return $this->render('portfolio/news/detail.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/news", name="news_create", methods={"POST"})
     */
    public function createNews(Request $request)
    {
        $news = new News();
        $data = json_decode($request->getContent(), true);
        $news->setTitle($data['title']);
        $news->setDescription($data['description']);
        $news->setPublicationDate(new \DateTime());
        $news->setAuthor($this->getUser());
        $news = $this->repository->save($news);

        $response = new Response(json_encode($news), Response::HTTP_CREATED);
        $response->send();
    }

    /**
     * @Route("/news/{id}", name="news_edit", methods={"POST"})
     */
    public function editNews(int $id, Request $request)
    {
        $news = $this->repository->findOneById($id);
        if(!$news) {
            $response = new Response('', Response::HTTP_NOT_FOUND);
            $response->send();
        }
        $data = json_decode($request->getContent(), true);
        $news->setTitle($data['title']);
        $news->setDescription($data['description']);
        $news->setLastEditDate(new \DateTime());
        $this->repository->save($news);

        $response = new Response($news->serialize(), Response::HTTP_OK);
        $response->send();
    }

    /**
     * @Route("/news/{id}", name="delete", methods={"DELETE"})
     */
    public function deleteNews(int $id)
    {
        $news = $this->repository->findOneById($id);
        if($news) {
            $this->repository->delete($news);
        }

        $response = new Response('', Response::HTTP_NO_CONTENT);
        $response->send();
    }
}
