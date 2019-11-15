<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadNews($manager);
    }

    public function loadNews(ObjectManager $manager)
    {
      foreach ($this->getNewsRawData() as [$title, $description, $publicationDate, $lastEditDate, $authorId]) {
          $news = new News();

          $news->setTitle($title);
          $news->setDescription($description);
          $news->setPublicationDate($publicationDate);
          $news->setLastEditDate($lastEditDate);
          $news->setAuthorId($authorId);

          $manager->persist($news);
      }
      $manager->flush();
    }


    private function getNewsRawData()
    {
        return [
          ['News - origine', 'Première news ajouté... c\'est beau', new \DateTime('2019-11-15 11:36:15'), null, 1],
          ['Beulette is back', 'What an incredible word: cute, fine, quick, lovely', new \DateTime(), null, 1]
        ];
    }
}
