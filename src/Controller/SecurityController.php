<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 14/09/2018
 * Time: 22:20
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route(name="administration", path="/administration")
     */
    public function administration(AuthenticationUtils $authenticationUtils) {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'error' => $error,
            'lastUsername' => $lastUsername
        ));
    }

    /**
     * @Route(name="logout", path="/logout")
     */
    public function logout() {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route(name="dashboard", path="/dashboard")
     */
    public function dashboard() {
        return $this->render('dashboard.html.twig');
    }
}