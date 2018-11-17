<?php

namespace App\Controller\Administration;

use App\Entity\User;
use App\Form\Type\User\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="userInformations", path="/administration/user/informations")
     */
    public function editInformations()
    {
        return $this->render('administration/user/informations.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     *
     */

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="changePassword", path="/administration/user/password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newPasswordEncoded = $encoder->encodePassword($user, $form->get('newPassword')->getData());
            $user->setPassword($newPasswordEncoded);

            $em->persist($user);
            $em->flush();

            $this->addFlash('confirm', 'Votre mot de passe a été modifié');

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('administration/user/password.html.twig', array(
            'form' => $form->createView()
        ));
    }
}