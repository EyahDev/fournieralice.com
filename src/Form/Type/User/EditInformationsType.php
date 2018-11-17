<?php

namespace App\Form\Type\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditInformationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EmailType::class, array(
            'label' => 'Adresse mail du compte'
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Votre prénom'
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Votre nom'
            ))
            ->add('submit', SubmitType::class, array(
            'label' => 'Enregistrer'
            ));
    }
}