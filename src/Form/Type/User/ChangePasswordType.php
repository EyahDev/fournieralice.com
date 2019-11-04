<?php

namespace App\Form\Type\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'label' => 'Votre ancien mot de passe',
                'invalid_message' => 'Votre ancien mot de passe n\'est pas valide',
                'required' => true,
                'mapped' => false,
                'constraints' => array(new UserPassword(array('message' => 'Votre ancien mot de passe n\'est pas valide')))
            ))
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'required' => true,
                'first_options' => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Répétez votre nouveau mot de passe'),
                'mapped' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Enregistrer'
            ));
    }
}