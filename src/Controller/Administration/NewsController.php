<?php

namespace App\Controller\Administration;

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

    /**
     * @Route("/administration/news/create", name="news_create")
     */
    public function createNews(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news->setAuthor($this->getUser());
            $news->setPublicationDate(new \DateTime());
            $this->getDoctrine()->getRepository(News::class)->save($news);

            $this->addFlash('confirm', 'La news ' . $news->getTitle() . ' a bien été créé');

            return $this->redirectToRoute('news');
        }

        return $this->render('administration/news/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/administration/news/{id}/edit", name="news_edit")
     */
    public function editNews(int $id, Request $request)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findOneById($id);
        if(!$news) {
            return $this->redirectToRoute('news');
        }

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news->setLastEditDate(new \DateTime());
            $this->getDoctrine()->getRepository(News::class)->save($news);

            $this->addFlash('confirm', 'La news ' . $news->getTitle() . ' a bien été modifié');

            return $this->redirectToRoute('news_single', array('id' => $id));
        }

        return $this->render('administration/news/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/administration/news/{id}/delete", name="news_delete")
     */
    public function deleteNews(int $id)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findOneById($id);
        if($news) {
            $this->getDoctrine()->getRepository(News::class)->delete($news);
            $this->addFlash('confirm', 'La news ' . $news->getTitle() . ' a bien été supprimé');
        }

        return $this->redirectToRoute('news');
    }
}
