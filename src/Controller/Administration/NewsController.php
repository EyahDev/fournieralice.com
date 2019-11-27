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
     * @return Response
     *
     * @Route(name="newsList", path="/administration/news")
     */
    public function NewsList()
    {
        return $this->render('administration/news/newsList.html.twig');
    }

    /**
     * @return Response
     *
     * @Route(name="newsEdit", path="/administration/news/{id}")
     */
    public function NewsEdit(int $id)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findOneById($id);
        if(!$news) {
            return $this->redirectToRoute('newsList');
        }

        return $this->render('administration/news/newsEdit.html.twig', array(
            'news' => $news,
        ));
    }
}
