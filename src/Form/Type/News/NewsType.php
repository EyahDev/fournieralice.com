<?php

namespace App\Form\Type\News;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Contenu',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 10]),
                ],
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Envoyer'
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
