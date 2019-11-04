<?php

namespace App\Controller\Administration;

use App\Entity\User;
use App\Form\Type\User\ChangePasswordType;
use App\Form\Type\User\EditInformationsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route(name="userInformations", path="/administration/user/informations")
     */
    public function editInformations(Request $request)
    {
        $user = $this->getUser();

        $oldEmail = $user->getUsername();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EditInformationsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash('confirm', 'Vos informations personnelles ont été mises à jour');

            if ($oldEmail !== $user->getUsername()) {
                return $this->redirectToRoute('logout');
            }

            return $this->redirectToRoute('userInformations');
        }

        return $this->render('administration/user/informations.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return RedirectResponse|Response
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

            return $this->redirectToRoute('changePassword');
        }

        return $this->render('administration/user/password.html.twig', array(
            'form' => $form->createView()
        ));
    }
}