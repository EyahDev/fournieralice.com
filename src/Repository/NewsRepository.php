<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function findAll()
    {
        return $this->createQueryBuilder('n')
                    ->orderBy('n.publicationDate', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    public function save(News $news)
    {
        $this->_em->persist($news);
        $this->_em->flush();
    }

    public function delete(News $news)
    {
        $this->_em->remove($news);
        $this->_em->flush();
    }

}
