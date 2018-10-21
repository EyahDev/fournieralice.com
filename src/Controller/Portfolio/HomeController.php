<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="homepage", path="/")
     */
    public function home() {
        return  $this->render('portfolio/home.html.twig');
    }
}