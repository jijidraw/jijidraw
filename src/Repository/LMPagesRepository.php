<?php

namespace App\Repository;

use App\Entity\LMPages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LMPages|null find($id, $lockMode = null, $lockVersion = null)
 * @method LMPages|null findOneBy(array $criteria, array $orderBy = null)
 * @method LMPages[]    findAll()
 * @method LMPages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LMPagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LMPages::class);
    }

    // /**
    //  * @return LMPages[] Returns an array of LMPages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LMPages
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
