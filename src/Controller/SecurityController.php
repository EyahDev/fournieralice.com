<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 14/09/2018
 * Time: 22:20
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\Type\lostPasswordType;
use App\Services\Utils\TokenGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route(name="administration", path="/administration")
     */
    public function administration(AuthenticationUtils $authenticationUtils)
    {
        if ($this->getUser()) {
//            return $this->redirectToRoute('dashboard');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'error' => $error,
            'lastUsername' => $lastUsername
        ));
    }

    /**
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @param TokenGeneratorService $tokenGenerator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route(name="lostPassword", path="/lost-password")
     */
    public function lostPassword(Request $request, \Swift_Mailer $mailer, TokenGeneratorService $tokenGenerator)
    {
        $form = $this->createForm(lostPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()['email'];

            $isValidEmail = $this->getDoctrine()->getRepository(User::class)->getUserEmail($email);

            if ($isValidEmail) {
                $message = (new \Swift_Message('Réinitialisation de votre mot de passe (fournieralice.com)'))
                    ->setFrom('noreply@adriendesmet.com')
                    ->setTo($email)
                    ->setBody($this->renderView('emails/reset-password.html.twig', ['token' => $tokenGenerator->generateRandomToken($email)]), 'text/html');
                $mailer->send($message);

                $this->addFlash('notice', 'Un email de réinitialisation de mot de passe vous a été envoyé.');

            } else {
                $this->addFlash('error', 'Cet email n\'existe pas.');
            }

            return $this->redirectToRoute('lostPassword');
        }

        return $this->render('security/lost_password.html.twig', array('form' => $form->createView()));
    }
}
