<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\News;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(News::class);
        $news = $repository->findAll();
        dump($news);

        return $this->render('portfolio/news/news.html.twig', [
            'news' => $news,
        ]);
    }
}
