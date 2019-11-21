<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 02/12/2018
 * Time: 12:51
 */

namespace App\Tests\Form;

use App\Form\Type\News\NewsType;
use App\Entity\News;
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


class NewsTypeTest extends TypeTestCase
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
     * Test si le formulaire est valide avec une description et un titre valide
     * Test si le formulaire est invalide sans titre et sans description
     * Test si le formulaire est invalide sans titre
     * Test si le formulaire est invalide sans description
     */
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'Unit test',
            'description' => 'Element créé pour les tests unitaires',
        ];

        $date = new \DateTime();

        $newsToCompare = new News();
        $newsToCompare->setPublicationDate($date);
        $form = $this->factory->create(NewsType::class, $newsToCompare);

        $news = new News();
        $news->setTitle('Unit test');
        $news->setDescription('Element créé pour les tests unitaires');
        $news->setPublicationDate($date);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($news->getTitle(), $newsToCompare->getTitle());
        $this->assertEquals($news->getDescription(), $newsToCompare->getDescription());
        $this->assertEquals($news->getPublicationDate(), $newsToCompare->getPublicationDate());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testSubmitInvalidData()
    {
        $formData = [
            'title' => '',
            'description' => '',
        ];

        $form = $this->factory->create(NewsType::class);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());

        // -----------------------------
        $formData = array(
            'title' => 'Unit test',
            'description' => '',
        );

        $form = $this->factory->create(NewsType::class);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());

        // -----------------------------
        $formData = array(
            'title' => '',
            'description' => 'Element créé pour les tests unitaires',
        );

        $form = $this->factory->create(NewsType::class);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isValid());
    }
}
