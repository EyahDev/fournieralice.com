<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;
use App\Entity\News;

class HomeController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="homepage", path="/")
     */
    public function home()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findForDisplay();

        return  $this->render('portfolio/home.html.twig', array(
            'news' => $news,
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="news", path="/news")
     */
    public function news()
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findForDisplay();

        return  $this->render('portfolio/news.html.twig', array(
            'newsList' => $news,
            'full' => true
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="news_detail", path="/news/{id}")
     */
    public function newsDetail(int $id)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findOneById($id);
        if(!$news) {
            return $this->redirectToRoute('homepage');
        }

        return  $this->render('portfolio/newsDetail.html.twig', array(
            'news' => $news
        ));
    }
}
