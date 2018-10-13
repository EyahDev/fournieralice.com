<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 15/09/2018
 * Time: 12:53
 */

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class lostPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, array(
            'label' => 'Email du mot de passe perdu'
        ));
        $builder->add('submit', SubmitType::class, array(
            'label' => 'Envoyer'
        ));
    }
}