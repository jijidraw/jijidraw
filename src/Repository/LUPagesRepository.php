<?php

namespace App\Repository;

use App\Entity\LUPages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LUPages|null find($id, $lockMode = null, $lockVersion = null)
 * @method LUPages|null findOneBy(array $criteria, array $orderBy = null)
 * @method LUPages[]    findAll()
 * @method LUPages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LUPagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LUPages::class);
    }
    

    // /**
    //  * @return LUPages[] Returns an array of LUPages objects
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
    public function findOneBySomeField($value): ?LUPages
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
