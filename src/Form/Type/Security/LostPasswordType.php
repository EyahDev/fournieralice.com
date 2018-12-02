<?php

namespace App\Form\Type\Security;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class LostPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'constraints' => array(
                    new Email(array('message' => "Veuillez saisir un email valide", 'checkMX' => true)),
                    new NotBlank(array('message' => "Veuillez saisir un email valide"))
                ),
                'label' => 'Email du mot de passe perdu',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Envoyer'
            ));
    }
}