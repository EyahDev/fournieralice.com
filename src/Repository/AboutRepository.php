<?php


namespace App\Repository;


use App\Entity\About;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;


/**
 * @method About|null find($id, $lockMode = null, $lockVersion = null)
 * @method About|null findOneBy(array $criteria, array $orderBy = null)
 * @method About[]    findAll()
 * @method About[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutRepository extends ServiceEntityRepository
{
    /**
     * AboutRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, About::class);
    }

    /**
     * Get content section
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function getContent(){
        return $this->createQueryBuilder('a')
            ->select('a.content')->getQuery()->getOneOrNullResult();
    }

    /**
     * Update content section
     * @param $content
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateAboutSection($content){
        $about = $this->findOneBy([]);
        $about->setContent($content);
        $this->_em->flush();
//        $this->_em->persist($about);
    }
}
