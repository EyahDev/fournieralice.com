<?php

namespace App\Form\Type\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class resetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', RepeatedType::class, array(
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe ne correspondent pas.',
            'required' => true,
            'first_options'  => array('label' => 'Nouveau mot de passe'),
            'second_options' => array('label' => 'Répétez votre nouveau mot de passe'),
        ));
        $builder->add('submit', SubmitType::class, array(
            'label' => 'Enregistrer'
        ));
    }
}