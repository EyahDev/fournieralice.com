<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 21/10/2018
 * Time: 11:32
 */

namespace App\Controller\Administration;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route(name="dashboard", path="/administration/dashboard")
     */
    public function dashboard()
    {
        return $this->render('administration/home.html.twig');
    }

    /**
     * @return Response
     *
     * @Route(name="aboutEdit", path="/administration/about")
     */
    public function AboutEdit(){
        return $this->render('administration/aboutEdit.html.twig');
    }
}