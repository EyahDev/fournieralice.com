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
     * @Route("/news/create", name="news_create")
     */
    public function createNews(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news->setAuthor($this->getUser());
            $news->setPublicationDate(new \DateTime());
            $news = $this->repository->save($news);

            $this->addFlash('confirm', 'La news a bien été créé');

            return $this->redirectToRoute('news');
        }

        return $this->render('portfolio/news/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/news/{id}", name="news_single", methods={"GET"})
     */
    public function getSingleNews(int $id)
    {
        $news = $this->repository->findOneById($id);
        if(!$news) {
            return $this->redirectToRoute('news');
        }

        return $this->render('portfolio/news/detail.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/news/{id}/edit", name="news_edit")
     */
    public function editNews(int $id, Request $request)
    {
        $news = $this->repository->findOneById($id);
        if(!$news) {
            return $this->redirectToRoute('news');
        }

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news->setLastEditDate(new \DateTime());
            $this->repository->save($news);

            $this->addFlash('confirm', 'La news a bien été modifié');

            return $this->redirectToRoute('news_single', array('id' => $id));
        }

        return $this->render('portfolio/news/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/news/{id}", name="news_delete", methods={"DELETE"})
     */
    public function deleteNews(int $id)
    {
        $news = $this->repository->findOneById($id);
        if($news) {
            $this->repository->delete($news);
        }

        return $this->redirectToRoute('news');
    }
}
