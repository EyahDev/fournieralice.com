<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 02/12/2018
 * Time: 12:51
 */

namespace App\Tests\Form;

use App\Form\Type\Security\LostPasswordType;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Tests\Fixtures\FakeMetadataFactory;
use Symfony\Component\Validator\Validator\RecursiveValidator;


class LostPasswordTypeTest extends TypeTestCase
{
    /**
     * @return array
     */
    protected function getExtensions()
    {
        $extensions = parent::getExtensions();
        $metadataFactory = new FakeMetadataFactory();
        $metadataFactory->addMetadata(new ClassMetadata(  Form::class));
        $validator = $this->createValidator($metadataFactory);

        $extensions[] = new CoreExtension();
        $extensions[] = new ValidatorExtension($validator);

        return $extensions;
    }

    /**
     * @param MetadataFactoryInterface $metadataFactory
     * @param array $objectInitializers
     * @return RecursiveValidator
     */
    protected function createValidator(MetadataFactoryInterface $metadataFactory, array $objectInitializers = array())
    {
        $translator = new IdentityTranslator();
        $translator->setLocale('en');
        $contextFactory = new ExecutionContextFactory($translator);
        $validatorFactory = new ConstraintValidatorFactory();
        return new RecursiveValidator($contextFactory, $metadataFactory, $validatorFactory, $objectInitializers);
    }

    /**
     * Test si le formulaire est valide avec une adresse mail valide
     * Test si le formulaire est invalide avec une adresse mail invalide
     * Test si le formulaire est invalide avec une chaine de caractère vide
     * Test si le formulaire est invalide avec une chaine de caractère null
     */
    public function testSubmitValidData() {
        $formData = array(
            'email' => 'test@mail.com',
        );

        $form = $this->factory->create(LostPasswordType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());

        // -----------------------------
        $formData = array(
            'email' => 'IsNotAEmail',
        );

        $form = $this->factory->create(LostPasswordType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());

        // -----------------------------
        $formData = array(
            'email' => '',
        );

        $form = $this->factory->create(LostPasswordType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());

        // -----------------------------
        $formData = array(
            'email' => null,
        );

        $form = $this->factory->create(LostPasswordType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());


    }
}