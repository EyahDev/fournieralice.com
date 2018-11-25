<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\Type\Security\LostPasswordType;
use App\Form\Type\Security\ResetPasswordType;
use App\Services\Utils\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route(name="administration", path="/administration")
     */
    public function administration(AuthenticationUtils $authenticationUtils)
    {
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
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @param TokenGenerator $tokenGenerator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route(name="lostPassword", path="/administration/password/lost")
     */
    public function lostPassword(Request $request, \Swift_Mailer $mailer, TokenGenerator $tokenGenerator)
    {
        $form = $this->createForm(LostPasswordType::class);
        $em = $this->getDoctrine();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()['email'];

            $user = $em->getRepository(User::class)->findOneBy(['username' => $email]);

            if ($user) {

                $token = $tokenGenerator->generateRandomToken(10);

                $user->resetPasswordTokenProcess($token);

                $em->getManager()->persist($user);
                $em->getManager()->flush();

                $message = (new \Swift_Message('Réinitialisation de votre mot de passe (fournieralice.com)'))
                    ->setFrom('noreply@adriendesmet.com')
                    ->setTo($email)
                    ->setBody($this->renderView('emails/reset-password.html.twig', ['token' => $token]), 'text/html');
                $mailer->send($message);

                $this->addFlash('notice', 'Un email de réinitialisation de mot de passe vous a été envoyé.');

            } else {
                $this->addFlash('error', 'Cet email n\'existe pas.');
            }

            return $this->redirectToRoute('lostPassword');
        }

        return $this->render('security/lost_password.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param $token
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route(name="resetPassword", path="/administration/password/reset/{token}")
     */
    public function resetPassword($token, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine();

        $user = $em->getRepository(User::class)->findOneBy(['resetPasswordToken' => $token]);

        if (!$user)     {
            throw new NotFoundHttpException('Cette page n\'existe pas');
        } elseif ($user && $user->getResetPasswordTokenValidityDate() < new \DateTime()) {
            return $this->render('security/invalid_token.html.twig');
        }

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $encoder->encodePassword($user, $form->get('password')->getData());

            $user->setPassword($encodedPassword);
            $user->setResetPasswordTokenValidityDate(null);
            $user->setResetPasswordToken(null);

            $em->getManager()->persist($user);
            $em->getManager()->flush();

            return $this->redirectToRoute('administration');
        }

        return $this->render('security/reset_password.html.twig', array('form' => $form->createView()));
    }
}
