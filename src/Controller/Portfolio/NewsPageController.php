<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;
use App\Form\Type\News\NewsType;
use App\Entity\News;

class NewsPageController extends AbstractController
{

    /**
     * @Route("/news", name="news", methods={"GET"})
     */
    public function getNews()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findAll();

        return $this->render('portfolio/news/news.html.twig', [
            'news_list' => $news,
        ]);
    }

    /**
     * @Route("/news/{id}", name="news_single", methods={"GET"})
     */
    public function getSingleNews(int $id)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findOneById($id);
        if(!$news) {
            return $this->redirectToRoute('news');
        }

        return $this->render('portfolio/news/detail.html.twig', [
            'news' => $news,
        ]);
    }
}
